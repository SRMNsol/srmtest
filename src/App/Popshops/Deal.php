<?php

namespace App\Popshops;

use Symfony\Component\DomCrawler\Crawler;
use Doctrine\Common\Collections\ArrayCollection;

class Deal implements DomCrawlerInterface
{
    use MerchantTrait;
    use DealCountTrait;

    protected $name;
    protected $dealTypes;
    protected $merchant;

    public function __construct(Crawler $node = null)
    {
        $this->dealTypes = new ArrayCollection();

        if (isset($node)) {
            $this->populateFromCrawler($node);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getDealTypes()
    {
        return $this->dealTypes;
    }

    public function populateFromCrawler(Crawler $node)
    {
        $this->setName($node->attr('name'));
        $this->setDealCount($node->attr('deal_count'));

        return $this;
    }
}
