<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Transaction;

class ProcessUserDataCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('migrate:user-data')
            ->setDescription('Populate db with old user data')
            ->addArgument('email', InputArgument::OPTIONAL, 'Process user by email');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $em = $app['orm.em'];
        $email = $input->getArgument('email');

        if (null !== $email) {
            $users = $em->getRepository('App\Entity\User')->findByEmail($email);
        } else {
            $users = $em->getRepository('App\Entity\User')->findAll();
        }

        $table = $this->getHelperSet()->get('table');
        $table->setHeaders(['Date', 'Order #', 'Amount', 'Cashback', 'Tag']);

        foreach ($users as $user) {
            $output->writeln($user->getEmail());
            $data = json_decode($user->getExtrabuxRawData(), true);

            if (!isset($data['summary']['transactions']) || !is_array($data['summary']['transactions']) || count($data['summary']['transactions']) === 0) {
                $output->writeln('No transactions');
                continue;
            }

            $table->setRows([]);

            foreach ($data['summary']['transactions'] as $transactionData) {
                $transaction = $em->getRepository('App\Entity\Transaction')->findOneByOrderNumber($transactionData['order_id']) ?: new Transaction();

                $transaction
                    ->setOrderNumber($transactionData['order_id'])
                    ->setTotal((float) $transactionData['amount'])
                    ->setCommission((float) $transactionData['cashback'])
                    ->setTag($transactionData['click_id'])
                    ->setRegisteredAt(\DateTime::createFromFormat('m/d/Y', $transactionData['report_date']))
                ;

                $em->persist($transaction);

                $table->addRow([
                    $transaction->getRegisteredAt()->format('m/d/Y'),
                    $transaction->getOrderNumber(),
                    sprintf('%.2f', $transaction->getTotal()),
                    sprintf('%.2f', $transaction->getCommission()),
                    $transaction->getTag(),
                ]);
            }

            $em->flush();
            $em->clear();
            $table->render($output);
        }

    }
}
