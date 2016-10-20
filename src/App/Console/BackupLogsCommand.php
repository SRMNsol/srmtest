<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class BackupLogsCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('dev:backup-logs')
            ->setDescription('Backup log files to S3')
            ->addArgument('backup-dir', InputArgument::REQUIRED, 'Backup directory (absolute path)');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $fs = new Filesystem();
        $backupDir = rtrim($input->getArgument('backup-dir'), '/');

        $finder = new Finder();
        $finder->files()->in($app['log_dir'])->name('{app,reporting}_*.log')->notName(sprintf('*_%s.log', date('Ymd')));

        if ($finder->count() > 0) {
            $output->writeln('Moving files to backup dir');

            foreach ($finder as $file) {
                $output->write(sprintf('* <comment>%s</comment> ... ', $file->getRelativePathname()));

                try {
                    $fs->copy($file, $backupDir.'/'.$file->getRelativePathname(), true);
                    $fs->remove($file);
                    $output->writeln('<info>OK</info>');
                } catch (\Exception $e) {
                    $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
                }
            }
        } else {
            $output->writeln('<comment>No files to backup</comment>');
        }

        $output->writeln('Done');
    }
}
