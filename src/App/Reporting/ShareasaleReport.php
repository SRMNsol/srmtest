<?php

namespace App\Reporting;

use Guzzle\Http\Message\Response as HttpResponse;
use Guzzle\Common\Event;
use Doctrine\ORM\EntityManager;
use App\Entity\Transaction;
use App\Entity\TransactionHistory;
use Symfony\Component\DomCrawler\Crawler;

/**
 * ShareASale reporting
 *
 * @link https://www.shareasale.com/a-apiManager.cfm
 */
class ShareasaleReport extends BaseReport
{
    /**
     * Find ShareASale network (ID = 1)
     */
    public function getNetwork()
    {
        return $this->findNetwork(1);
    }

    public static function create($affiliateId, $token, $apiSecret, EntityManager $em, array $plugins = null)
    {
        return self::createClient(
            'https://shareasale.com/x.cfm',
            [
                'request.options' => [
                    'query' => [
                        'version' => '1.8',
                        'affiliateId' => $affiliateId,
                        'token' => $token,
                        'xmlFormat' => 1,
                    ],
                    'events' => [
                        'request.before_send' => function (Event $e) use ($token, $apiSecret) {
                            $request = $e['request'];
                            $date = new \DateTime();
                            $utcDate = $date->format(\DateTime::RFC1123);
                            $action = $request->getUrl(true)->getQuery()->get('action');
                            $signature = sprintf('%s:%s:%s:%s', $token, $utcDate, $action, $apiSecret);
                            $hash = strtoupper(hash('sha256', $signature));

                            $request->setHeader('x-ShareASale-Date', $utcDate);
                            $request->setHeader('x-ShareASale-Authentication', $hash);
                        },
                        'request.sent' => [function (Event $e) {
                            $request = $e['request'];
                            $response = $request->getResponse();
                            $body = $response->getBody(true);
                            if (false !== strpos($body, 'Error Code')) {
                                throw new \RuntimeException(trim($body));
                            }
                        }, 500], // higher than request.sent priority of cache plugin to prevent cache
                    ],
                ],
            ],
            $em,
            $plugins
        );
    }

    public function responseCallback(HttpResponse $response)
    {
        return new Crawler($response->getBody(true));
    }

    public function getActivityDetailsReport(\DateTime $from, \DateTime $to)
    {
        $requests = [];
        $start = clone $from;

        do {
            $end = clone $start;
            $end->add(\DateInterval::createFromDateString('60 days'));
            if ($end > $to) {
                $end = clone $to;
            }

            $requests[] = [
                '{?action,dateStart,dateEnd}', [
                    'action' => 'activity',
                    'dateStart' => $start->format('m/d/Y'),
                    'dateEnd' => $end->format('m/d/Y'),
                ]
            ];

            $start = clone $end;

            // end is inclusive, add 1 day
            $start->add(\DateInterval::createFromDateString('1 day'));

        } while ($end < $to);

        $crawlers = $this->parallelRequests($requests, 1);

        $transactions = [];
        $em = $this->em;

        foreach ($crawlers as $crawler) {
            $crawler->filter('activitydetailsreport activitydetailsreportrecord')->each(function (Crawler $node) use (&$transactions, $em) {
                if (!preg_match('/Sale - (.*)/', $node->filter('comment')->text(), $matches)) {
                    throw new \RuntimeException(sprintf('Order number not found in: %s', $node->filter('comment')->text()));
                }
                $orderNumber = $matches[1];

                $index = sprintf('%s-%s', $node->filter('merchantid')->text(), $orderNumber);

                $merchant = $this->findMerchant($node->filter('merchantid')->text());
                $transaction = $this->findTransaction($merchant, $orderNumber, false) ?: new Transaction();

                $transaction->setRegisteredAt(\DateTime::createFromFormat('m/d/Y H:i:s A', $node->filter('transdate')->text()));
                $transaction->setOrderNumber($orderNumber);
                $transaction->setTag($node->filter('affcomment')->text());
                $transaction->setNetwork($this->getNetwork());
                $transaction->setMerchant($merchant);

                // set values
                if ($transaction->getHistory()->count() === 0) {
                    $transaction->setTotal($this->parseMoney($node->filter('transamount')->text()));
                    $transaction->setCommission($this->parseMoney($node->filter('commission')->text()));
                }

                // status
                if ($node->filter('voided')->text()) {
                    $transaction->setTotal(0.00);
                    $transaction->setCommission(0.00);
                    $transaction->setStatus(Transaction::STATUS_CANCELED);
                } else {
                    // paid
                    $paidAt = \DateTime::createFromFormat('Y-m-d', $node->filter('paiddate')->text());
                    if ($paidAt instanceof \DateTime && $paidAt < new \DateTime()) {
                        $transaction->setStatus(Transaction::STATUS_PROCESSED);
                    }
                }

                // track
                $transactions[$index] = $transaction;

                $em->persist($transaction);

                // we want to flush each individual transaction to facilitate listeners
                $em->flush();
            });
        }

        return $transactions;
    }

    public function getLedgerReport(\DateTime $from , \DateTime $to)
    {
        $crawler = $this->request([
            '{?action,dateStart,dateEnd,includeOrderDetails}', [
                'action' => 'ledger',
                'dateStart' => $from->format('m/d/Y'),
                'dateEnd' => $to->format('m/d/Y'),
                'includeOrderDetails' => 1,
            ]
        ]);

        $transactions = [];
        $em = $this->em;

        // index all registered transactions
        $crawler->filter('ledger ledgerrecord')->each(function (Crawler $node) use (&$transactions, $em) {
            $index = sprintf('%s-%s', $node->filter('merchantid')->text(), $node->filter('ordernumber')->text());

            $merchant = $this->findMerchant($node->filter('merchantid')->text());
            $transaction = $this->findTransaction($merchant, $node->filter('ordernumber')->text(), false);

            if ($transaction !== null) {
                $transactions[$index] = $transaction;
            }
        });

        // find records per transaction
        foreach ($transactions as $transaction) {
            $iterator = $transaction->getHistoryByDate($from, $to)->getIterator();

            $crawler->filterXPath(sprintf('//ordernumber[text()="%s"]/..', $transaction->getOrderNumber()))->each(function ($node) use ($transaction, $iterator, $em) {
                $history = $iterator->valid() ? $iterator->current() : new TransactionHistory();

                if (false === $transaction->getHistory()->contains($history)) {
                    $transaction->addHistory($history);
                }

                // map values
                $history->setRegisteredAt(\DateTime::createFromFormat('Y-m-d H:i:s.u', $node->filter('dt')->text()));
                $history->setTotal($this->parseMoney($node->filter('orderimpact')->text()));
                $history->setCommission($this->parseMoney($node->filter('impact')->text()));

                $em->persist($history);

                $iterator->next();
            });

            // remove non existent history
            while ($iterator->valid()) {
                $history = $iterator->current();
                $transaction->removeHistory($history);
                $iterator->next();
            }

            // calculate
            $transaction->updateFromHistory();
            $em->flush();
        }

        return $transactions;
    }
}
