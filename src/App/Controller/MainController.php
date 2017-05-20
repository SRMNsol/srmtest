<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;

class MainController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function dashboard(Application $app)
    {
        $em = $app['orm.em'];
        $connection = $em->getConnection();
        
        $RAW_QUERY = "SELECT  SUM( available ) AS count_available, SUM( pending )as total_pending, SUM( processing )as total_processing, SUM( paid )as total_paid
                    FROM  `Payable` 
                    WHERE  (available !='0.00' OR pending !='0.00' OR processing !='0.00' OR paid !='0.00') 
                    AND  `user_id` !=  'NULL'";
                    //print_r($RAW_QUERY); exit();
       
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $cashback = $statement->fetch();
        
//        echo "<pre>"; print_r($cashback); exit;
        
        $merchants['total'] = $this->em->createQuery('SELECT COUNT(m) FROM App\Entity\Merchant m')->getSingleScalarResult();
        $merchants['totalNoCashback'] = $this->em->createQuery('SELECT COUNT(m) FROM App\Entity\Merchant m WHERE m.commission = 0')->getSingleScalarResult();
        $merchants['totalLogoDownloaded'] = $this->em->createQuery('SELECT COUNT(m) FROM App\Entity\Merchant m WHERE m.logoPath IS NOT NULL')->getSingleScalarResult();
        $merchants['totalLogoInvalid'] = $this->em->createQuery('SELECT COUNT(m) FROM App\Entity\Merchant m WHERE m.logoPath IS NULL AND m.logoUpdatedAt IS NOT NULL')->getSingleScalarResult();


        $networks = $this->em->createQuery('SELECT n FROM App\Entity\Network n WHERE n.lastTransactionDownloadAt IS NOT NULL OR n.lastTransactionHistoryDownloadAt IS NOT NULL')->getResult();


            $RAW_QUERY = 'SELECT referral_status FROM user WHERE id=157476';
            $statement = $connection->prepare($RAW_QUERY);
            $statement->execute();
            $refchecks = $statement->fetchAll();

            $ref=$refchecks[0]['referral_status'];


            $RAW_QUERY = 'SELECT popup_status FROM user WHERE uid=10';
            $statement = $connection->prepare($RAW_QUERY);
            $statement->execute();
            $refchecks = $statement->fetchAll();

            $popup=$refchecks[0]['popup_status'];


        return new Response($app['twig']->render('dashboard.html.twig', [
            'merchants' => $merchants,
            'networks' => $networks,
            'cashbackamount' => $cashback,
            'refcheck' => $ref,
            'popup' => $popup,
        ]));
    }
}
