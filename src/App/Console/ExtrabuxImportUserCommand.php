<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use App\Entity\User;

class ExtrabuxImportUserCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('extrabux:import:user')
            ->setDescription('Populate db with old user data')
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
        $table->setHeaders(['Id', 'Extrabux Id', 'Email', 'Referrer']);

        foreach ($results as $row) {
            $user = $row[0];

            $output->writeln($user->getEmail());
            $data = json_decode($user->getExtrabuxRawUserData(), true);

            if (is_array($data)) {
                $user->setAddress($data['address']);
                $user->setCity($data['city']);
                $user->setState($data['state']);
                $user->setZip($data['zip']);

                if ($data['parent_id'] > 0) {
                    $referrer = $em->getRepository('App\Entity\User')->findOneByExtrabuxId($data['parent_id']);
                    $user->setReferredBy($referrer);
                }

                $user->setStatus(strtolower($data['status']));

                $em->persist($user);
            } else {
                $output->writeln('No extrabux data');
            }

            $table->setRows([[
                $user->getId(),
                $user->getExtrabuxId(),
                $user->getEmail(),
                (null !== $user->getReferredBy()) ? $user->getReferredBy()->getEmail() : null,
            ]]);

            $em->flush();
            $em->clear();
            $table->render();
        }

    }
}
