<?php

namespace App\Popshops;

use Symfony\Component\DomCrawler\Crawler;

class DealType implements DomCrawlerInterface
{
    use DealCountTrait;

    protected $id;
    protected $name;

    public function __construct(Crawler $node = null)
    {
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

    public function populateFromCrawler(Crawler $node)
    {
        $this->setId($node->attr('id'));
        $this->setName($node->attr('name'));
        $this->setDealCount($node->attr('deal_count'));

        return $this;
    }
}
