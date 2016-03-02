<?php

namespace App\Reporting;

use Guzzle\Http\Message\Response as HttpResponse;
use Doctrine\ORM\EntityManager;
use App\Entity\Transaction;
use App\Entity\TransactionHistory;

/**
 * Linkshare (Rakuten Marketing) Reporting
 *
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
            'https://api.rakutenmarketing.com/advancedreports/1.0',
            [
                'request.options' => [
                    'query' => ['token' => $securityToken],
                ],
            ],
            $em,
            $plugins
        );
    }

    protected function responseCallback(HttpResponse $response)
    {
        $csv = [];
        $lines = str_getcsv($response->getBody(true), "\n");
        $fields = str_getcsv(array_shift($lines));
        foreach ($lines as $line) {
            $data = str_getcsv($line);
            $csv[] = array_combine($fields, $data);
        }

        return $csv;
    }

    public function getSignatureOrderReport(\DateTime $from, \DateTime $to)
    {
        $csv = $this->request(['{?bdate,edate,reportid}', [
            'bdate' => $from->format('Ymd'),
            'edate' => $to->format('Ymd'),
            'reportid' => 12 // signature orders
        ]]);

        $transactions = [];

        foreach ($csv as $row) {
            $index = sprintf('%s-%s', $row['Merchant ID'], $row['Order ID']);

            $merchant = $this->findMerchant($row['Merchant ID']);
            $transaction = $this->findTransaction($merchant, $row['Order ID'], false) ?: new Transaction();

            $transaction->setRegisteredAt(\DateTime::createFromFormat('m/d/Y H:i', $row['Transaction Date'] . ' ' . $row['Transaction Time']));
            $transaction->setOrderNumber($row['Order ID']);
            $transaction->setTag($row['Member ID']);
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
            $iterator = $transaction->getHistoryByDate($from, $to)->getIterator();

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
                $history->setRegisteredAt(\DateTime::createFromFormat('m/d/Y H:i', $row['Process Date'] . ' ' . $row['Process Time']));
                $history->setItemNumber($row['SKU Number']);
                $history->setTotal($this->parseMoney($row['Sales']));
                $history->setCommission($this->parseMoney($row['Commissions']));

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
