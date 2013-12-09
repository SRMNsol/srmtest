<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Referral;
use App\Entity\Payable;

class ExtrabuxImportAdjustmentCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('extrabux:import:adjustment')
            ->setDescription('Create adjustment payable')
            ->addArgument('email', InputArgument::OPTIONAL, 'Process user by email');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $em = $app['orm.em'];
        $email = $input->getArgument('email');

        $queryBuilder = $em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\User', 'u')
        ;

        if (null !== $email) {
            $queryBuilder
                ->where('u.email = :email')
                ->setParameter('email', $email)
            ;
        }

        $results = $queryBuilder->getQuery()->iterate();

        $table = $this->getHelperSet()->get('table');
        $table->setHeaders(['Amount', 'Pending', 'Available', 'Processing', 'Paid', 'Adjustment']);

        foreach ($results as $row) {
            $user = $row[0];

            $output->writeln($user->getEmail());
            $data = json_decode($user->getExtrabuxRawData(), true);

            if (!isset($data['summary']['total'][0]) || !is_array($data['summary']['total'][0])) {
                $output->writeln('No summary data for user');
                continue;
            }

            $summaryData = $em->getRepository('App\Entity\Payable')->calculateUserSummary($user);

            if (!is_array($summaryData)) {
                $output->writeln('No payable data for user');
                continue;
            }

            $table->setRows([]);

            $diff = new Payable();
            $diff->setConcept('Adjustments');
            $diff->setPending($data['summary']['total'][0]['pending'] - $summaryData['pending']);
            $diff->setAvailable($data['summary']['total'][0]['available'] - $summaryData['available']);
            $diff->setProcessing($data['summary']['total'][0]['processing'] - $summaryData['processing']);
            $diff->setPaid($data['summary']['total'][0]['paid'] - $summaryData['paid']);
            $diff->setAmount(
                $data['summary']['total'][0]['pending']
                + $data['summary']['total'][0]['available']
                + $data['summary']['total'][0]['processing']
                + $data['summary']['total'][0]['paid']
                - $summaryData['amount']
            );

            if ($diff->getAmount() > 0) {
                $diff->setUser($user);
                $em->persist($diff);
                $em->flush();
                $output->writeln(sprintf('Adjustment: %.2f', $diff->getAmount()));

                // recalculate
                $summaryData = $em->getRepository('App\Entity\Payable')->calculateUserSummary($user);
            }

            $table->addRow([
                sprintf('%.2f', $summaryData['amount']),
                sprintf('%.2f', $summaryData['pending']),
                sprintf('%.2f', $summaryData['available']),
                sprintf('%.2f', $summaryData['processing']),
                sprintf('%.2f', $summaryData['paid']),
                sprintf('%.2f', $diff->getAmount()),
            ]);

            $em->flush();
            $em->clear();
            $table->render($output);
        }

    }
}
