<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use App\Entity\Referral;

class ExtrabuxImportReferralCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('extrabux:import:referral')
            ->setDescription('Populate db with old referral data')
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

        $table = new Table($output);
        $table->setHeaders(['Month', 'Direct', 'Indirect']);

        foreach ($results as $row) {
            $user = $row[0];

            $output->writeln($user->getEmail());
            $data = json_decode($user->getExtrabuxRawData(), true);

            if (!isset($data['summary']['reftransactions']) || !is_array($data['summary']['reftransactions']) || count($data['summary']['reftransactions']) === 0) {
                $output->writeln('No referral transactions');
                continue;
            }

            $table->setRows([]);

            foreach ($data['summary']['reftransactions'] as $refData) {
                $referral = $em->getRepository('App\Entity\Referral')->findOneBy([
                    'availableAt' => \DateTime::createFromFormat('d/m/Y', '01/' . $refData['date']),
                    'user' => $user,
                ]) ?: new Referral();

                $referral
                    ->setUser($user)
                    ->setConcept('Referral Total')
                    ->setAvailableAt(\DateTime::createFromFormat('d/m/Y', '01/' . $refData['date']))
                    ->setAvailable($refData['referralavailable'])
                    ->setPending($refData['referralpending'])
                    ->setProcessing($refData['referralprocessing'])
                    ->setPaid($refData['referralpaid'])
                    ->setDirect($refData['referralcommissiondirect'])
                    ->setIndirect($refData['referralcommissionindirect'])
                    ->setAmount($refData['referralcommissiondirect'] + $refData['referralcommissionindirect'])
                ;

                $em->persist($referral);

                $table->addRow([
                    $referral->getConcept(),
                    $referral->getDirect(),
                    $referral->getIndirect(),
                ]);
            }

            $em->flush();
            $em->clear();
            $table->render();
        }

    }
}
