<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MailerTestCommand extends Command
{
    public function configure()
    {
        $this->setName('beesavy:mailer:test');
        $this->setDescription('Send test mail');
        $this->addArgument('to', InputArgument::OPTIONAL, 'Destination email (default to postmaster@beesavy.com)');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $message = \Swift_Message::newInstance()
            ->setSubject('[Beesavy] Mailer Test')
            ->setFrom('no-reply@beesavy.com')
            ->setTo($input->getArgument('to') ?: 'postmaster@beesavy.com')
            ->setBody('Test Message')
            ->addPart('<html><body><h1>Test Message</h1></body></html>', 'text/html');

        $output->writeln(sprintf('Sending message to %s', implode(', ', array_keys($message->getTo()))));

        /* Logger */
        $logger = new \Swift_Plugins_Loggers_ArrayLogger();
        $app['mailer']->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));

        $app['mailer']->send($message);

        /**
         * Flush queue
         *
         * @link http://silex.sensiolabs.org/doc/providers/swiftmailer.html#usage-in-commands
         */
        $spool = $app['swiftmailer.spooltransport']->getSpool();
        $spool->flushQueue($app['swiftmailer.transport']);

        $output->writeln('=== Log ================================');
        $output->writeln($logger->dump());
        $output->writeln('=== Message ============================');
        $output->writeln($message->toString());
    }
}
