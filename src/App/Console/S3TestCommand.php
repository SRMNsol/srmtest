<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class S3TestCommand extends Command
{
    public function configure()
    {
        $this->setName('dev:test-s3');
        $this->setDescription('Test read and write to S3 bucket');
        $this->addOption('prod', null, InputOption::VALUE_NONE, 'Push to production S3');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $bucket = $input->getOption('prod')
            ? 's3://static.beesavy.com'
            : 's3://static-dev.beesavy.com';

        $dialog = $this->getHelper('dialog');

        $output->writeln(sprintf('Using <comment>%s</comment> bucket <info>%s</info>',
            $input->getOption('prod') ? 'PRODUCTION' : 'DEV',
            $bucket
        ));

        $credentials = $app['aws.s3']->getCredentials();
        if (null === $credentials) {
            throw new \RuntimeException('No credentials found for S3 client');
        }

        $output->writeln(sprintf('Key: <info>%s</info>', $credentials->getAccessKeyId()));
        $output->writeln(sprintf('Secret: <info>%s</info>', null === $credentials->getSecretKey() ? '' : '[set]'));
        $output->writeln(sprintf('Token: <info>%s</info>', null === $credentials->getSecurityToken() ? '' : '[set]'));
        $output->writeln(sprintf('Expiration: <info>%s</info> (current time <comment>%s</comment>)',
            $credentials->getExpiration() ? \DateTime::createFromFormat('U', $credentials->getExpiration())->format('Y-m-d H:i:s') : '',
            date('Y-m-d H:i:s')
        ));

        if (false === $dialog->askConfirmation($output, '<question>Continue ?</question> [y/N] ', false)) {
            $output->writeln('Aborting');
            return;
        }

        $fs = new Filesystem();

        try {
            $output->write('Creating source file ...');
            $source = new File($app['temp_dir'].'/'.uniqid(mt_rand()).'.txt', false);
            $fs->dumpFile($source, 'Hello!');
            $output->writeln(sprintf(' <info>OK</info> <comment>%s</comment>', $source));

            $output->write('Copy to S3 bucket ...');
            $target = $bucket.'/test_'.uniqid(mt_rand()).'/test.txt';
            $fs->copy($source, $target);

            $copy = null;
            for ($i = 1; $i <= 20; $i++) {
                $output->write('.');
                if ($i > 1) {
                    sleep(1);
                }

                $copy = current(iterator_to_array(Finder::create()->in(dirname($target))->files()));
                if (isset($copy)) {
                    break;
                }

                if ($i === 10) {
                    throw new \Exception(sprintf('No files found in %s after %d seconds', dirname($target), $i));
                }
            }
            $output->writeln(sprintf(' <info>OK</info> <comment>%s</comment>', $copy));

            if ($dialog->askConfirmation($output, '<question>Clean up files ?</question> [Y/n] ', true)) {
                $output->write('Clean up ...');
                $fs->remove([$source, dirname($copy)]);
                $output->writeln(' <info>OK</info>');
            }

            $output->writeln('Done');

        } catch (\Exception $e) {
            $output->writeln(' <error>Failed</error>');
            $output->writeln((string) $e);
        }
    }
}
