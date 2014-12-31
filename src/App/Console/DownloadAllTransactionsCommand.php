<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use App\Entity\Network;

class DownloadAllTransactionsCommand extends Command
{
    public function configure()
    {
        $this->setName('beesavy:transactions');
        $this->setDescription('Download transactions from all networks');
        $this->addArgument('start-date', InputArgument::OPTIONAL, 'Start date');
        $this->addArgument('end-date', InputArgument::OPTIONAL, 'End date');
    }

    protected function getTransactionDownloadArguments(InputInterface $input, Network $network, $type = 'transaction')
    {
        $args['start-date'] = $input->getArgument('start-date');
        $args['end-date'] = $input->getArgument('end-date');

        $last = null;
        switch ($type) {
            case 'transaction' :
                $last = $network->getLastTransactionDownloadAt();
                break;
            case 'history' :
                $last = $network->getLastTransactionHistoryDownloadAt();
                break;
            default :
                throw new \Exception('Invalid download type');
        }

        $yesterday = new \DateTime('yesterday');
        $yesterday->setTime(0, 0);
        if ($last >= $yesterday) {
            /* because last will be +1 day, maximum yesterday */
            $last = new \DateTime('2 days ago');
        } elseif ($last instanceof \DateTime) {
            /* clone to avoid modifying network */
            $last = clone $last;
        }

        if ($args['start-date'] === null && $args['end-date'] === null) {
            $args['start-date'] = $last ? $last->add(\DateInterval::createFromDateString('+1 day'))->format('Y-m-d') : null;
            $args['end-date']   = $last ? 'yesterday' : null;
        }

        return $args;
    }

    protected function updateDownloadDate(Network $network, array $args, $type = 'transaction')
    {
        $app = $this->getSilexApplication();

        $last = null;
        switch ($type) {
            case 'transaction' :
                $last = $network->getLastTransactionDownloadAt();
                break;
            case 'history' :
                $last = $network->getLastTransactionHistoryDownloadAt();
                break;
            default :
                throw new \Exception('Invalid download type');
        }

        $endDate = null;

        if ($args['start-date'] === null && $args['end-date'] === null) {
            $endDate = new \DateTime('yesterday');
        } elseif ($args['start-date'] !== null && $args['end-date'] === null) {
            $endDate = new \DateTime($args['start-date']);
        } else {
            $endDate = new \DateTime($args['end-date']);
        }

        $today = new \DateTime();
        $today->setTime(0, 0);
        if ($endDate >= $today) {
            /* always set to maximum yesterday because next download is +1 day */
            $endDate = new \DateTime('yesterday');
        }
        $endDate->setTime(0, 0);

        if ($endDate > $last) {
            if ($type === 'transaction') {
                $network->setLastTransactionDownloadAt($endDate);
            } else {
                $network->setLastTransactionHistoryDownloadAt($endDate);
            }
        }

        $app['orm.em']->flush();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $output->writeln('Popshops network and stores');

        $ret = $this->getApplication()->find('api:networks')->run(new ArrayInput([
            'command' => 'api:networks',
            '--catalog-key' => $app['popshops.catalog_keys']['all_stores']
        ]), $output);

        /**
         * Linkshare (ID 4)
         */
        $output->writeln('Linkshare');

        $network = $app['orm.em']->find('App\Entity\Network', 4);
        $args = $this->getTransactionDownloadArguments($input, $network);
        $ret = $this->getApplication()->find('linkshare:transactions')->run(new ArrayInput([
            'command' => 'linkshare:transactions',
        ] + $args), $output);
        $this->updateDownloadDate($network, $args);

        /**
         * Comission Junction(ID 2)
         */
        $output->writeln('CJ');

        $network = $app['orm.em']->find('App\Entity\Network', 2);
        $args = $this->getTransactionDownloadArguments($input, $network);
        $ret = $this->getApplication()->find('cj:transactions')->run(new ArrayInput([
            'command' => 'cj:transactions',
        ] + $args), $output);
        $this->updateDownloadDate($network, $args);

        /**
         * EBay Enterprise (ID 8)
         */
        $output->writeln('Pepperjam');

        $network = $app['orm.em']->find('App\Entity\Network', 8);
        $args = $this->getTransactionDownloadArguments($input, $network);
        $ret = $this->getApplication()->find('pepperjam:transactions')->run(new ArrayInput([
            'command' => 'pepperjam:transactions',
        ] + $args), $output);
        $this->updateDownloadDate($network, $args);

        $args = $this->getTransactionDownloadArguments($input, $network, 'history');
        $ret = $this->getApplication()->find('pepperjam:transactions')->run(new ArrayInput([
            'command' => 'pepperjam:transactions',
            '--update' => true,
        ] + $args), $output);
        $this->updateDownloadDate($network, $args, 'history');

        /**
         * Share A Sale (ID 1)
         */
        $output->writeln('Shareasale');

        $network = $app['orm.em']->find('App\Entity\Network', 1);
        $args = $this->getTransactionDownloadArguments($input, $network);
        $ret = $this->getApplication()->find('shareasale:transactions')->run(new ArrayInput([
            'command' => 'shareasale:transactions',
        ] + $args), $output);
        $this->updateDownloadDate($network, $args);

        $args = $this->getTransactionDownloadArguments($input, $network, 'history');
        $ret = $this->getApplication()->find('shareasale:transactions')->run(new ArrayInput([
            'command' => 'shareasale:transactions',
            '--update' => true,
        ] + $args), $output);
        $this->updateDownloadDate($network, $args, 'history');

        /**
         * Impact Radius (ID 15)
         */
        $output->writeln('Impact Radius');

        $network = $app['orm.em']->find('App\Entity\Network', 15);
        $args = $this->getTransactionDownloadArguments($input, $network);
        $ret = $this->getApplication()->find('impactradius:transactions')->run(new ArrayInput([
            'command' => 'impactradius:transactions',
        ] + $args), $output);
        $this->updateDownloadDate($network, $args);
    }
}
