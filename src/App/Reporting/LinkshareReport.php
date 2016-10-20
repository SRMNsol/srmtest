<?php

namespace App\Reporting;

use Guzzle\Http\Message\Response as HttpResponse;
use Doctrine\ORM\EntityManager;
use App\Entity\Transaction;
use App\Entity\TransactionHistory;

/**
 * Linkshare (Rakuten Marketing) Reporting
 *
 * @link http://cli.linksynergy.com/cli/publisher/home.php?lang=en (LOGIN)
 * @link https://developers.rakutenmarketing.com/subscribe/apis/info?name=AdvancedReports&version=1.0&provider=LinkShare (NEW)
 * @link http://helpcenter.linkshare.com/publisher/categories.php?categoryid=34 (OLD)
 */
class LinkshareReport extends BaseReport
{
    /**
     * Find Linkshare network entity (ID = 4)
     */
    public function getNetwork()
    {
        return $this->findNetwork(4);
    }

    public static function create($securityToken, EntityManager $em, array $plugins = null)
    {
        return self::createClient(
            'https://ran-reporting.rakutenmarketing.com/en/reports/signature-orders-report/filters',
            [
                'request.options' => [
                    'query' => [
                        'include_summary' => 'Y',
                        'network' => 1,
                        'token' => $securityToken
                    ],
                ],
            ],
            $em,
            $plugins
        );
    }

    protected function responseCallback(HttpResponse $response)
    {
        $csv = [];
        $fields = [];
        $lines = str_getcsv($response->getBody(true), "\n");

        foreach ($lines as $line) {
            // get data, strip carriage return
            $data = str_getcsv(rtrim($line, "\r"));

            // skip lines not part of CSV
            if (count($data) !== 12) {
                continue;
            }

            if (empty($fields)
                && $data[0]  === 'Member ID (U1)'
                && $data[1]  === 'MID'
                && $data[2]  === 'Advertiser Name'
                && $data[3]  === 'Order ID'
                && $data[4]  === 'Transaction Date'
                && $data[5]  === 'Transaction Time'
                && $data[6]  === 'SKU'
                && $data[7]  === 'Sales'
                && $data[8]  === '# of Items'
                && $data[9]  === 'Total Commission'
                && $data[10] === 'Process Date'
                && $data[11] === 'Process Time'
            ) {
                $fields = $data;
            } elseif (!empty($fields)) {
                $csv[] = array_combine($fields, $data);
            }
        }

        // empty data should at least contain fields
        if (empty($fields)) {
            throw new \Exception('Invalid CSV report: missing required fields');
        }

        return $csv;
    }

    public function getSignatureOrderReportByProcessDate(\DateTime $from, \DateTime $to)
    {
        return $this->getSignatureOrderReport($from, $to, 'process');
    }


    public function getSignatureOrderReportByTransactionDate(\DateTime $from, \DateTime $to)
    {
        return $this->getSignatureOrderReport($from, $to, 'transaction');
    }

    protected function getSignatureOrderReport(\DateTime $from, \DateTime $to, $dateType)
    {
        // normalize time
        $from->setTime(0, 0);
        $to->setTime(0, 0);

        $csv = $this->request(['{?start_date,end_date,tz,date_type}', [
            'start_date' => $from->format('Y-m-d'),
            'end_date' => $to->format('Y-m-d'),
            'tz' => 'GMT',
            'date_type' => $dateType,
        ]]);

        $transactions = [];

        foreach ($csv as $row) {
            $index = sprintf('%s-%s', $row['MID'], $row['Order ID']);

            $merchant = $this->findMerchant($row['MID']);
            $transaction = $this->findTransaction($merchant, $row['Order ID'], false) ?: new Transaction();

            $transaction->setRegisteredAt(\DateTime::createFromFormat('n/j/y H:i:s', $row['Transaction Date'] . ' ' . $row['Transaction Time']));
            $transaction->setOrderNumber($row['Order ID']);
            $transaction->setTag($row['Member ID (U1)']);
            $transaction->setNetwork($this->getNetwork());
            $transaction->setMerchant($merchant);

            // track
            $transactions[$index] = $transaction;

            $this->em->persist($transaction);

            // we want to flush each individual transaction to facilitate listeners
            $this->em->flush();
        }

        // find records per transaction
        foreach ($transactions as $transaction) {
            $iterator = $dateType === 'process'
                ? $transaction->getHistoryByDate($from, $to)->getIterator() // if run by process date, we update history in the date range
                : $transaction->getHistory()->getIterator(); // if run by transaction date, we update al history

            $count = $iterator->count();
            foreach ($csv as $row) {
                if ($row['Order ID'] != $transaction->getOrderNumber()) {
                    continue;
                }

                $history = $iterator->valid() ? $iterator->current() : new TransactionHistory();

                if (false === $transaction->getHistory()->contains($history)) {
                    $transaction->addHistory($history);
                }

                // map values
                $history->setRegisteredAt(\DateTime::createFromFormat('n/j/y H:i:s', $row['Process Date'] . ' ' . $row['Process Time']));
                $history->setItemNumber($row['SKU']);
                $history->setTotal($this->parseMoney($row['Sales']));
                $history->setCommission($this->parseMoney($row['Total Commission']));

                $this->em->persist($history);

                $iterator->next();
            }

            // remove non existent history
            while ($iterator->valid()) {
                $history = $iterator->current();
                $transaction->removeHistory($history);
                $iterator->next();
            }

            // calculate
            $transaction->updateFromHistory();
            $this->em->flush();
        }

        return $transactions;
    }
}
