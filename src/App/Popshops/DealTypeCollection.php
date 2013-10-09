<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DomCrawler\Crawler;

class DealTypeCollection extends ArrayCollection implements DomCrawlerInterface
{
    use TotalCountTrait;

    public function __construct($node = [])
    {
        parent::__construct(is_array($node) ? $node : []);
        if ($node instanceof Crawler) {
            $this->populateFromCrawler($node);
        }
    }

    public function populateFromCrawler(Crawler $node)
    {
        $collection = $this;

        $node->filter('deal_type')->each(function (Crawler $node, $i) use ($collection) {
            $dealType = new DealType($node);
            $collection->set($dealType->getId(), $dealType);
        });
    }
}
