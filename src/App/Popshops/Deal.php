<?php

namespace App\Popshops;

use Symfony\Component\DomCrawler\Crawler;
use Doctrine\Common\Collections\ArrayCollection;

class Deal implements DomCrawlerInterface
{
    use MerchantTrait;
    use DealCountTrait;

    protected $name;
    protected $url;
    protected $specific = false;
    protected $startOn;
    protected $endOn;
    protected $dealTypes;

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

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getSpecific()
    {
        return $this->specific;
    }

    public function setSpecific($specific)
    {
        $this->specific = (boolean) $specific;

        return $this;
    }

    public function getStartOn()
    {
        return $this->startOn;
    }

    public function setStartOn(\DateTime $date)
    {
        $this->startOn = $date;

        return $this;
    }

    public function getEndOn()
    {
        return $this->endOn;
    }

    public function setEndOn(\DateTime $date)
    {
        $this->endOn = $date;

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
        $this->setUrl($node->attr('url'));
        $this->setSpecific($node->attr('specific'));

        if ($startOn = \DateTime::createFromFormat('m/d/Y', $node->attr('start_on'))) {
            $this->setStartOn($startOn);
        }

        if ($endOn = \DateTime::createFromFormat('m/d/Y', $node->attr('end_on'))) {
            $this->setEndOn($endOn);
        }

        return $this;
    }
}
