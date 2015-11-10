<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCategoriesCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('dev:export-categories')
            ->setDescription('Export categories and related merchants in SQL');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $categories = $app['orm.em']->getRepository('App\Entity\Category')->findAll();

        $sqls[] = 'SET FOREIGN_KEY_CHECKS = 0';
        $sqls[] = 'TRUNCATE TABLE Category';
        $sqls[] = 'UPDATE Merchant SET category_id = NULL';
        $sqls[] = 'SET FOREIGN_KEY_CHECKS = 1';

        foreach ($categories as $category) {
            $sqls[] = sprintf('INSERT INTO Category (id, name) VALUES (%d, %s)', $category->getId(), $app['db']->quote($category->getName(), \PDO::PARAM_STR));

            $merchants = $category->getMerchants();
            if ($merchants->count() > 0) {
                $sqls[] = sprintf('UPDATE Merchant SET category_id = %d WHERE id IN (%s)', $category->getId(), join(', ', array_map(function ($merchant) use ($app) {
                    return $merchant->getId();
                }, $merchants->toArray())));
            }
        }

        foreach ($sqls as $sql) {
            $output->writeln($sql.';');
        }
    }
}
