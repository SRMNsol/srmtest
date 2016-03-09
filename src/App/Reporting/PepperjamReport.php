<?php

namespace App\Reporting;

use Guzzle\Http\Message\Response as HttpResponse;
use Doctrine\ORM\EntityManager;
use App\Entity\Transaction;
use App\Entity\TransactionHistory;

/**
 * EBay Enterprise Affiliate Network reporting
 *
 * @link http://help.pepperjamnetwork.com/api/publisher
 */
class PepperjamReport extends BaseReport
{
    /**
     * Find eBay Enterprise network (ID = 8)
     */
    public function getNetwork()
    {
        return $this->findNetwork(8);
    }

    protected function responseCallback(HttpResponse $response)
    {
        return json_decode($response->getBody(true));
    }

    public static function create($publisherApiKey, EntityManager $em, array $plugins = null)
    {
        return self::createClient(
            'http://api.pepperjamnetwork.com/20120402/',
            [
                'request.options' => [
                    'query' => ['apiKey' => $publisherApiKey, 'format' => 'json'],
                ],
            ],
            $em,
            $plugins
        );
    }

    /**
     * End date is inclusive
     *
     * Status map
     *   paid => STATUS_PROCESSED
     *   pending, locked, delayed, unconfirmed => STATUS_REGISTERED
     */
    public function getTransactionDetailsReport(\DateTime $from, \DateTime $to)
    {
        // normalize time
        $from->setTime(0, 0);
        $to->setTime(0, 0);

        $json = $this->request([
            'publisher/report/transaction-details{?startDate,endDate}', [
                'startDate' => $from->format('Y-m-d'),
                'endDate' => $to->format('Y-m-d'),
            ]
        ]);

        $transactions = [];

        foreach ($json->data as $item) {
            $index = sprintf('%s-%s', $item->program_id, $item->order_id);

            $merchant = $this->findMerchant($item->program_id);
            $transaction = $this->findTransaction($merchant, $item->order_id, false) ?: new Transaction();

            $transaction->setRegisteredAt(new \DateTime($item->date));
            $transaction->setOrderNumber($item->order_id);
            $transaction->setTag($item->sid);
            $transaction->setNetwork($this->getNetwork());
            $transaction->setMerchant($merchant);

            // values
            if ($transaction->getHistory()->count() === 0) {
                $transaction->setTotal($this->parseMoney($item->sale_amount));
                $transaction->setCommission($this->parseMoney($item->commission));
            }

            // status
            if ($item->status === 'paid') {
                $transaction->setStatus(Transaction::STATUS_PROCESSED);
            }

            // add to array
            $transactions[$index] = $transaction;

            $this->em->persist($transaction);

            // we want to flush each individual transaction to facilitate listeners
            $this->em->flush();
        }

        return $transactions;
    }

    public function getTransactionDeltaReport(\DateTime $from, \DateTime $to)
    {
        // normalize time
        $from->setTime(0, 0);
        $to->setTime(0, 0);

        $requests = [];
        $start = clone $from;

        do {
            $end = clone $start;
            $end->add(\DateInterval::createFromDateString('30 days'));
            if ($end > $to) {
                $end = clone $to;
            }

            $requests[] = [
                'publisher/report/transaction-delta{?startDate,endDate}', [
                    'startDate' => $start->format('Y-m-d'),
                    'endDate' => $end->format('Y-m-d'),
                ]
            ];

            $start = clone $end;

            // end is inclusive, add 1 day
            $start->add(\DateInterval::createFromDateString('1 day'));

        } while ($end < $to);

        $docs = $this->parallelRequests($requests, 2); // max 2 requests in parallel

        $transactions = [];

        foreach ($docs as $json) {
            foreach ($json->data as $item) {
                $index = sprintf('%s-%s', $item->program_id, $item->order_id);

                $merchant = $this->findMerchant($item->program_id);
                $transaction = $this->findTransaction($merchant, $item->order_id, false);

                if ($transaction !== null) {
                    $transactions[$index] = $transaction;
                }
            }
        }

        // find records per transaction
        foreach ($transactions as $transaction) {
            $iterator = $transaction->getHistoryByDate($from, $to)->getIterator();

            $count = $iterator->count();
            foreach ($docs as $json) {
                foreach ($json->data as $item) {
                    if ($item->order_id != $transaction->getOrderNumber()) {
                        continue;
                    }

                    $history = $iterator->valid() ? $iterator->current() : new TransactionHistory();

                    if (false === $transaction->getHistory()->contains($history)) {
                        $transaction->addHistory($history);
                    }

                    // map values
                    $history->setRegisteredAt(new \DateTime($item->date));
                    $history->setItemNumber($item->item_id);
                    $history->setTotal($this->parseMoney($item->sale_amount));
                    $history->setCommission($this->parseMoney($item->commission));

                    $this->em->persist($history);

                    $iterator->next();
                }
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
