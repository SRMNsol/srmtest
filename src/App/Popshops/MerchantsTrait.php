<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

trait MerchantsTrait
{
    protected $merchants;
    protected $merchantTypes;
    protected $em;

    public function getMerchants()
    {
        return $this->merchants;
    }

    public function setMerchants(MerchantCollection $merchants)
    {
        $this->merchants = $merchants;

        return $this;
    }

    public function getMerchantTypes()
    {
        return $this->merchantTypes;
    }

    public function setMerchantTypes(ArrayCollection $merchantTypes)
    {
        $this->merchantTypes = $merchantTypes;

        return $this;
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function setEntityManager(EntityManager $em = null)
    {
        $this->em = $em;

        return $this;
    }

    public function populateMerchantsFromCrawler(Crawler $nodes)
    {
        if (null !== $this->em) {
            $ids = $nodes->extract('id');
            $merchants = $this->em->getRepository('App\Popshops\Merchant')->findBy(['id' => $ids]);
            foreach ($merchants as $merchant) {
                $this->merchants[$merchant->getId()] = $merchant;
            }
        }

        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $id = $node->attr('id');

            if (isset($this->merchants[$id])) {
                $merchant = $this->merchants[$id];
                $merchant->populateFromCrawler($node);
            } else {
                $merchant = new Merchant($node);
                $this->merchants[$id] = $merchant;

                if (null !== $this->em) {
                    $this->em->persist($merchant);
                }
            }
        }

        if (null !== $this->em) {
            $this->em->flush();
        }
    }

    public function populateMerchantTypesFromCrawler(Crawler $nodes)
    {
        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $id = $node->attr('id');

            if (isset($this->merchantTypes[$id])) {
                $merchantType = $this->merchantTypes[$id];
                $merchantType->populateFromCrawler($node);
            } else {
                $merchantType = new MerchantType($node);
                $this->merchantTypes[$id] = $merchantType;
            }
        }
    }
}
