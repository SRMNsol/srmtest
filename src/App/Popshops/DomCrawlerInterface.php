<?php

namespace App\Popshops;

use Symfony\Component\DomCrawler\Crawler;

interface DomCrawlerInterface
{
    public function populateFromCrawler(Crawler $node);
}
