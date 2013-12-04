<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Transaction;
use App\Entity\Cashback;

class ExtrabuxImportTransactionCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('extrabux:import:transaction')
            ->setDescription('Populate db with old transaction and cashback data')
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
            $user = $em->merge($user);

            $output->writeln($user->getEmail());
            $data = json_decode($user->getExtrabuxRawData(), true);

            if (!isset($data['summary']['transactions']) || !is_array($data['summary']['transactions']) || count($data['summary']['transactions']) === 0) {
                $output->writeln('No transactions');
                continue;
            }

            $table->setRows([]);

            foreach ($data['summary']['transactions'] as $transactionData) {
                $transaction = $em->getRepository('App\Entity\Transaction')->findOneBy([
                    'orderNumber' => $transactionData['order_id'],
                    'tag' => $transactionData['click_id'],
                ]) ?: new Transaction();

                $transaction
                    ->setOrderNumber($transactionData['order_id'])
                    ->setTotal((float) $transactionData['amount'])
                    ->setCommission((float) $transactionData['cashback'])
                    ->setTag($transactionData['click_id'])
                    ->setRegisteredAt(\DateTime::createFromFormat('m/d/Y', $transactionData['created']))
                ;

                // Level 1 cashback
                $cashback = $transaction->getCashback() ?: new Cashback();

                $transaction->setCashback($cashback);

                $cashback
                    ->setUser($user)
                    ->setConcept($transactionData['merchant'])
                    ->setAmount((float) $transactionData['cashback'])
                    ->setAvailableAt(\DateTime::createFromFormat('F j, Y', preg_replace('/\s+/', ' ', $transactionData['available_date'])))
                    // resetting values
                    ->setPending(0.00)
                    ->setAvailable(0.00)
                    ->setProcessing(0.00)
                    ->setPaid(0.00)
                ;

                switch ($transactionData['status']) {
                    case 'Pending' :
                        $cashback->setPending($cashback->getAmount());
                        break;
                    case 'Available' :
                        $cashback->setAvailable($cashback->getAmount());
                        break;
                    case 'Processing' :
                        $cashback->setProcessing($cashback->getAmount());
                        break;
                    case 'Paid' :
                        $cashback->setPaid($cashback->getAmount());
                        break;
                    case 'Returned' :
                        $cashback->setStatus(Cashback::STATUS_CANCELLED);
                        break;
                    default :
                        throw new \Exception('Unexpected status ' . $transactionData['status']);
                }

                $em->persist($transaction);
                $em->persist($cashback);

                $table->addRow([
                    $transaction->getRegisteredAt()->format('m/d/Y'),
                    $transaction->getOrderNumber(),
                    sprintf('%.2f', $transaction->getTotal()),
                    sprintf('%.2f', $transaction->getCashback()->getAmount()),
                    $transaction->getTag(),
                ]);
            }

            $em->flush();
            $em->clear();
            $table->render($output);
        }

    }
}
