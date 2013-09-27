<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ProductCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('popshops:products')
            ->setDescription('Find products on main catalog')
            ->addArgument('keywords', InputArgument::OPTIONAL, 'Specify the product search keywords');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getHelperSet()->get('container')->getContainer();
        $popshops = $app['popshops.client'];
        $catalogs = $app['popshops.catalog_keys'];
        $catalog = 'all_stores';

        if (!isset($catalogs[$catalog])) {
            $dialog = $this->getHelperSet()->get('dialog');
            $catalog = $dialog->askAndValidate(
                $output,
                'Please specify the catalog (' . implode(', ', array_keys($catalogs)) . '): ',
                function ($answer) use ($catalogs) {
                    if (!isset($catalogs[$answer])) {
                        throw new \RunTimeException('Invalid catalog name');
                    }

                    return $answer;
                },
                3
            );
        }

        $keywords = $input->getArgument('keywords');

        $result = $popshops->findProducts($catalogs[$catalog], $keywords);
        if (count($result->getProducts()) > 0) {
            $table = $this->getHelperSet()->get('table');
            $table->setHeaders(['Name', 'Merchant', 'Price']);

            foreach ($result->getProducts() as $product) {
                $table->addRow(array(
                    $product->getName(),
                    $product->getMerchant() ? $product->getMerchant()->getName() : null,
                    number_format($product->getMerchantPrice(), 2),
                ));
            }

            $table->render($output);

            $output->writeln('Keywords: ' . $result->getKeywords());
            $output->writeln('Limit/offset: ' . $result->getLimit() . '/' . $result->getOffset());
            $output->writeln('Total results: ' . $result->getItemCount());

            return;
        }

        $output->writeln('No products found');
    }
}
