<?php

namespace App\Reporting;

use App\Entity\Merchant;
use App\Entity\Transaction;

abstract class BaseReport extends BaseClient
{
    protected $network;

    abstract function getNetwork();

    /**
     * Find network by id
     */
    protected function findNetwork($id)
    {
        if (null === $this->network) {
            $this->network = $this->em->getRepository('App\Entity\Network')->findOneBy(['popshopsId' => $id]);
            if (null === $this->network) {
                throw new \Exception(sprintf('Network with popshopsId %d not found', $id));
            }
        }

        return $this->network;
    }

    /**
     * Find merchant by network merchant id
     */
    protected function findMerchant($networkMerchantId, $required = true)
    {
        $merchant = $this->em->getRepository('App\Entity\Merchant')->findOneBy([
            'network' => $this->getNetwork(),
            'networkMerchantId' => $networkMerchantId,
        ]);

        if (null === $merchant && $required) {
            throw new \Exception(sprintf('%s merchant networkMerchantId %s not found', $this->getNetwork()->getName(), $networkMerchantId));
        }

        return $merchant;
    }

    /**
     * Find transaction, uniquely identified by order number and item number (SKU)
     */
    protected function findTransaction(Merchant $merchant, $orderNumber, $required = true)
    {
        $transaction = $this->em->getRepository('App\Entity\Transaction')->findOneBy([
            'merchant' => $merchant,
            'orderNumber' => $orderNumber,
        ]);

        if (null === $transaction && $required) {
            throw new \Exception(sprintf('Unregistered transaction %s for %s', $orderNumber, $merchant->getName()));
        }

        return $transaction;
    }
}
