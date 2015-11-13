<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class PopshopsMerchantIdCommand extends Command
{
    public function configure()
    {
        $this->setName('dev:max-merchant-id');
        $this->setDescription('Get max merchant id from popshops available merchants xml');
        $this->addArgument('url', InputArgument::REQUIRED, 'Merchants xml url');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $crawler = new Crawler(file_get_contents($input->getArgument('url')));

        $maxId = 0;
        $crawler->filter('Merchant')->each(function (Crawler $node, $i) use (&$maxId) {
            if ($maxId < $merchantId = $node->attr('id')) {
                $maxId = $merchantId;
            }
        });

        $output->writeln(sprintf('Max merchant id: %d', $maxId));
    }
}
