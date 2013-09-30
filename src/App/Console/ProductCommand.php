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
            ->addArgument('keywords', InputArgument::OPTIONAL, 'Specify the product search keywords')
            ->addOption('print-filters', null, InputOption::VALUE_NONE, 'If set, will print all available filters' );
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
            $table->setRows($result->getProducts()->map(function ($product) {
                return [
                    substr($product->getName(), 0, 100),
                    $product->getMerchant() ? $product->getMerchant()->getName() : null,
                    number_format($product->getMerchantPrice(), 2),
                ];

            })->toArray());
            $table->render($output);

            if ($input->getOption('print-filters')) {
                $table->setHeaders(['Price Min', 'Price Max', 'Count']);
                $table->setRows($result->getPriceRanges()->map(function ($priceRange) {
                    return [$priceRange->getMinPrice(), $priceRange->getMaxPrice(), $priceRange->getItemCount()];
                })->toArray());
                $table->render($output);

                $table->setHeaders(['Brand', 'Count']);
                $table->setRows($result->getBrands()->map(function ($brand) {
                    return [$brand->getName(), $brand->getItemCount()];
                })->toArray());
                $table->render($output);

                $table->setHeaders(['Merchant Type', 'Count']);
                $table->setRows($result->getMerchantTypes()->map(function ($merchantType) {
                    return [$merchantType->getName(), $merchantType->getItemCount()];
                })->toArray());
                $table->render($output);

                $table->setHeaders(['Suggested Merchant', 'Count']);
                $table->setRows($result->getSuggestedMerchants()->map(function ($merchant) {
                    return [$merchant->getName(), $merchant->getItemCount()];
                })->toArray());
                $table->render($output);
            }

            $output->writeln('Keywords: ' . $result->getKeywords());
            $output->writeln('Limit/offset: ' . $result->getLimit() . '/' . $result->getOffset());
            $output->writeln('Total results: ' . $result->getItemCount());

            return;
        }

        $output->writeln('No products found');
    }
}
