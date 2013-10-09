<?php

namespace App\Popshops;

use Symfony\Component\DomCrawler\Crawler;
use Doctrine\Common\Collections\ArrayCollection;

class Deal implements DomCrawlerInterface
{
    use MerchantTrait;
    use DealCountTrait;

    protected $id;
    protected $name;
    protected $description;
    protected $url;
    protected $specific = false;
    protected $startOn;
    protected $endOn;
    protected $code;
    protected $dealTypes;

    public function __construct(Crawler $node = null)
    {
        $this->dealTypes = new ArrayCollection();

        if (isset($node)) {
            $this->populateFromCrawler($node);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($desc)
    {
        $this->description = $desc;

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

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getDealTypes()
    {
        return $this->dealTypes;
    }

    public function populateFromCrawler(Crawler $node)
    {
        $this->setId($node->attr('id'));
        $this->setName($node->attr('name'));
        $this->setDescription($node->attr('description'));
        $this->setUrl($node->attr('url'));
        $this->setSpecific($node->attr('specific'));
        $this->setDealCount($node->attr('deal_count'));

        if ($startOn = \DateTime::createFromFormat('m/d/Y', $node->attr('start_on'))) {
            $this->setStartOn($startOn);
        }

        if ($endOn = \DateTime::createFromFormat('m/d/Y', $node->attr('end_on'))) {
            $this->setEndOn($endOn);
        }

        $this->setCode($node->attr('code'));

        return $this;
    }
}
