<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateLogoCommand extends Command
{
    public function configure()
    {
        $this->setName('beesavy:merchant:logo');
        $this->setDescription('Update merchant logo');
        $this->addArgument('id', InputArgument::OPTIONAL, 'Merchant Id');
        $this->addOption('limit', null, InputOption::VALUE_REQUIRED, 'Limit number of merchants');
        $this->addOption('days', null, InputOption::VALUE_REQUIRED, 'Update logo after number of days');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $id = $input->getArgument('id');
        $limit = $input->getOption('limit');
        $lastUpdateDays = null === $input->getOption('days') ? 30 : $input->getOption('days');

        $output->writeln('Processing logo images');
        $output->writeln(sprintf('Download path <info>%s</info>', $app['temp_dir']));
        $output->writeln(sprintf('Upload path <info>%s</info>', $app['bucket_dir']));

        $dialog = $this->getHelper('dialog');

        if (false === $dialog->askConfirmation($output, '<question>Continue ?</question> [Y/n] ', true)) {
            $output->writeln('Aborting');
            return;
        }

        $qb = $app['orm.em']->createQueryBuilder()
            ->select('m')
            ->from('App\Entity\Merchant', 'm');

        if (isset($id)) {
            $qb
                ->where('m.id = :id')
                ->setParameter('id', (int) $id);
        } else {
            $qb
                ->where('m.logoUpdatedAt IS NULL')
                ->orWhere('m.logoUpdatedAt <= :last')
                ->setParameter('last', new \DateTime(sprintf('%d days ago', $lastUpdateDays)))
                ->orderBy('m.logoUpdatedAt', 'ASC')
                ->setMaxResults($limit);
        }

        $i = 0;
        foreach ($qb->getQuery()->iterate() as $row) {
            $merchant = $row[0];
            try {
                $output->writeln(sprintf('[%d] <comment>%s</comment>: %s',
                    $merchant->getId(),
                    $merchant->getName(),
                    $merchant->getLogoUrl()
                ));

                if ($merchant->getSkipLogoUpdate() === true) {
                    $output->writeln('==> <comment>automatic update disabled</comment>');
                } else {
                    $app['logo_manager']->updateLogo($merchant);
                }
                $output->writeln(sprintf('==> <info>%s</info>', $merchant->getLogoAbsolutePath()));
            } catch (ORMException $e) {
                throw $e;
            } catch (\Exception $e) {
                // manually set date and continue
                $merchant->setLogoUpdatedAt(new \DateTime());
                $app['orm.em']->flush();
                $output->writeln(sprintf('==> <error>%s</error>', $e->getMessage()));
            }

            if (($i % 50) === 0) {
                $app['orm.em']->clear();
            }
            ++$i;
        }
    }
}
