<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RemovePaymentCommand extends Command
{
    public function configure()
    {
        $this->setName('dev:remove-payment');
        $this->setDescription('Remove payment and reset amounts');
        $this->addArgument('id', InputArgument::REQUIRED, 'Payment id');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $em = $app['orm.em'];

        $payment = $em->find('App\Entity\Payment', $input->getArgument('id'));
        if ($payment === null) {
            throw new \Exception('Invalid payment id');
        }

        $em->remove($payment);
        $em->flush();
        $output->writeln('Payment deleted');
    }
}
