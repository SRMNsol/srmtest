<?php

namespace App\Reporting;

use Guzzle\Http\Message\Response as HttpResponse;
use Symfony\Component\DomCrawler\Crawler;
use Doctrine\ORM\EntityManager;
use App\Entity\Transaction;
use App\Entity\TransactionHistory;

/**
 * Commission Junction Reporting
 *
 * @link http://help.cj.com/en/web_services/web_services.htm
 */
class CommissionJunctionReport extends BaseReport
{
    /**
     * Find Commission Junction network (ID = 2)
     */
    public function getNetwork()
    {
        return $this->findNetwork(2);
    }

    protected function responseCallback(HttpResponse $response)
    {
        return new Crawler($response->getBody(true));
    }

    public static function create($developerKey, EntityManager $em, array $plugins = null)
    {
        return self::createClient(
            'https://commission-detail.api.cj.com/v3/',
            [
                'request.options' => [
                    'headers' => [
                        'authorization' => $developerKey,
                    ]
                ]
            ],
            $em,
            $plugins
        );
    }

    /**
     * End date is exclusive
     *
     * Status map
     *   new      => STATUS_REGISTERED
     *   locked   => STATUS_REGISTERED
     *   extended => STATUS_REGISTERED
     *   closed   => STATUS_PROCESSED
     */
    public function getCommissionDetailReport(\DateTime $from, \DateTime $to)
    {
        $to = clone $to;
        $to->add(\DateInterval::createFromDateString('1 day'));

        $requests = [];
        $start = clone $from;
        $end = clone $start;

        do {
            $end->add(\DateInterval::createFromDateString('31 days'));
            if ($end > $to) {
                $end = clone $to;
            }

            $requests[] = [
                'commissions{?date-type,start-date,end-date}', [
                'date-type' => 'posting',
                'start-date' => $start->format('Y-m-d'),
                'end-date' => $end->format('Y-m-d'),
            ]];

            $start = clone $end;
        } while ($end < $to);

        $crawlers = $this->parallelRequests($requests);

        $transactions = [];
        $updates = [];
        $em = $this->em;

        foreach ($crawlers as $crawler) {
            $crawler->filter('commissions commission')->each(function (Crawler $node) use (&$transactions, &$updates, $em) {
                $index = $node->filter('original-action-id')->text();
                $isOriginal = $node->filter('original')->text() === 'true' ? true : false;

                $merchant = $this->findMerchant($node->filter('cid')->text());
                $transaction = $this->findTransaction($merchant, $node->filter('order-id')->text(), false) ?: new Transaction();

                $transaction->setRegisteredAt(new \DateTime($node->filter('event-date')->text()));
                $transaction->setOrderNumber($node->filter('order-id')->text());
                $transaction->setTag($node->filter('sid')->text());
                $transaction->setNetwork($this->getNetwork());
                $transaction->setMerchant($merchant);

                // set values on original transactions and no history
                if ($isOriginal && $transaction->getHistory()->count() === 0) {
                    $transaction->setTotal($this->parseMoney($node->filter('sale-amount')->text()));
                    $transaction->setCommission($this->parseMoney($node->filter('commission-amount')->text()));
                } else {
                    $updates[$index] = $transaction;
                }

                // status
                if ($node->filter('action-status')->text() === 'closed') {
                    $transaction->setStatus(Transaction::STATUS_PROCESSED);
                }

                // add to array
                $transactions[$index] = $transaction;

                $em->persist($transaction);

                // we want to flush each individual transaction to facilitate listeners
                $this->em->flush();
            });
        }

        // process update list in batch of 50 (max)
        for ($offset = 0; $offset < count($updates); $offset += 50) {
            $this->getItemDetailReport(array_slice($updates, $offset, 50, true));
        }

        return $transactions;
    }

    public function getItemDetailReport(array $transactions)
    {
        $crawler = $this->request(['item-detail/{original-action-ids}', [
            'original-action-ids' => implode(',', array_keys($transactions))
        ]]);

        foreach ($transactions as $originalActionId => $transaction) {
            $iterator = $transaction->getHistory()->getIterator();

            $crawler->filter(sprintf('item-details[original-action-id="%s"] item', $originalActionId))->each(function (Crawler $node) use ($transaction, $iterator) {
                $history = $iterator->valid() ? $iterator->current() : new TransactionHistory();

                if (false === $transaction->getHistory()->contains($history)) {
                    $transaction->addHistory($history);
                }

                $isCorrection = $node->filter('quantity')->text() < 0;

                // map values
                $history->setRegisteredAt(new \DateTime($node->filter('posting-date')->text()));
                $history->setItemNumber($node->filter('sku')->text());
                $history->setTotal(round(($isCorrection ? -1 : 1) * $this->parseMoney($node->filter('sale-amount')->text()), 2));
                $history->setCommission(round(($isCorrection ? -1 : 1) * $this->parseMoney($node->filter('publisher-commission')->text()), 2));

                $this->em->persist($history);

                $iterator->next();
            });

            // remove non existent history
            while ($iterator->valid()) {
                $history = $iterator->current();
                $transaction->removeHistory($history);
                $iterator->next();
            }

            // calculate and flush per transaction to facilitate listener
            $transaction->updateFromHistory();
            $this->em->flush();
        }

        return $transactions;
    }
}
