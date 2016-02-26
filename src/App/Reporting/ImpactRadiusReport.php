<?php

namespace App\Reporting;

use Guzzle\Http\Message\Response as HttpResponse;
use Symfony\Component\DomCrawler\Crawler;
use Doctrine\ORM\EntityManager;
use App\Entity\Transaction;
use App\Entity\TransactionHistory;

/**
 * Impact Radius Reporting
 *
 * @link http://dev.impactradius.com/display/api
 */
class ImpactRadiusReport extends BaseReport
{
    /**
     * Find Impact Radius network (ID = 15)
     */
    public function getNetwork()
    {
        return $this->findNetwork(15);
    }

    protected function responseCallback(HttpResponse $response)
    {
        // return as associated array due to field names
        return json_decode($response->getBody(true), true);
    }

    public static function create($accountSid, $authToken, EntityManager $em, array $plugins = null)
    {
        return self::createClient(
            'https://api.impactradius.com/2010-09-01/Mediapartners/{accountSid}/',
            [
                'accountSid' => $accountSid,
                'request.options' => [
                    'auth' => [$accountSid, $authToken, 'Basic']
                ],
            ],
            $em,
            $plugins
        );
    }

    /**
     * Call to Media Partner Actions
     * End date is exclusive
     *
     * @link http://dev.impactradius.com/display/api/Media+Partner+Actions
     *
     * Status map
     *   PENDING  => STATUS_REGISTERED
     *   APPROVED => STATUS_PROCESSED
     *   REVERSED => STATUS_CANCELED
     */
    public function getActionsReport(\DateTime $from, \DateTime $to)
    {
        $end = clone $to;
        $end->add(\DateInterval::createFromDateString('1 day'));

        $start = clone $from;

        $request = [
            'Actions.json{?StartDate,EndDate}', [
                'StartDate' => $start->format(\DateTime::ISO8601),
                'EndDate' => $end->format(\DateTime::ISO8601)
            ]
        ];

        $json = $this->request($request);

        $transactions = [];
        $em = $this->em;

        $items = isset($json['Actions']) ? $json['Actions'] : [];

        // $items is action object when there is only 1 result
        if (array_key_exists('Id', $items)) {
            $items = [$items];
        }

        foreach ($items as $item) {
            $index = sprintf('%s-%s', $item['CampaignId'], $item['Id']);

            $merchant = $this->findMerchant($item['CampaignId']);
            $transaction = $this->findTransaction($merchant, $item['Id'], false) ?: new Transaction();

            $transaction->setRegisteredAt(\DateTime::createFromFormat(\DateTime::ISO8601, $item['CreationDate']));
            $transaction->setOrderNumber($item['Id']);
            $transaction->setTag($item['SubId1']);
            $transaction->setNetwork($this->getNetwork());
            $transaction->setMerchant($merchant);

            // set values
            $transaction->setTotal($this->parseMoney($item['Amount']));
            $transaction->setCommission($this->parseMoney($item['Payout']));
            switch ($item['State']) {
                case 'PENDING' :
                    $transaction->setStatus(Transaction::STATUS_REGISTERED);
                    break;
                case 'APPROVED' :
                    $transaction->setStatus(Transaction::STATUS_PROCESSED);
                    break;
                case 'REVERSED' :
                    $transaction->setStatus(Transaction::STATUS_CANCELED);
                    break;
            }

            // add to array
            $transactions[$index] = $transaction;

            $em->persist($transaction);

            // we want to flush each individual transaction to facilitate listeners
            $this->em->flush();
        };

        return $transactions;
    }
}
