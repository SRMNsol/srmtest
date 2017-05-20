<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use App\Form\UserSearchType;
use App\Form\ReportShoppingType;
use App\Form\ReportStoreType;
use App\Form\UserAccountType;
use App\Form\Model\UserAccount;
use App\Entity\User;

class ReportingController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
	
        $this->em = $em;
    }

    public function shoppingbydate(Request $request, Application $app)
    {
        //echo "muzammil"; exit;
        $searchForm = $app['form.factory']->create(new ReportShoppingType());
        $em = $app['orm.em'];
        $searchForm->handleRequest($request);
        if ($searchForm->isValid()) {
            // search user
            try {
                $data = $searchForm->getData();
                $startdate=$data["startDate"];
                $enddate=$data["endDate"];
               
                
                $starts = date("Y-m-d",strtotime($startdate->format('Y-m-d')));
                $ends = date("Y-m-d",strtotime($enddate->format('Y-m-d')));
                $where = "STR_TO_DATE(a.registeredAt, '%Y-%m-%d') between STR_TO_DATE('".$starts."',  '%Y-%m-%d') AND STR_TO_DATE('".$ends."', '%Y-%m-%d')";
                $connection = $em->getConnection();
                $RAW_QUERY = 'SELECT  `a`. * ,  `p`.user_id AS user_id,  `m`.name AS merchant_name,  `u`.email AS user_email
                                FROM (
                                `AdvertiserTransaction` AS a
                                )
                                JOIN  `Merchant` AS m ON  `m`.`id` =  `a`.`merchant_id` 
                                JOIN  `Payable` AS p ON  `p`.`id` =  `a`.`cashback_id` 
                                JOIN  `user` AS u ON  `u`.`uid` =  `p`.`user_id` where '.$where;
                $statement = $em->getConnection()->prepare($RAW_QUERY);
                $statement->execute();
                $result = $statement->fetchAll();
                
                //$user = $em->getRepository('App\Entity\User')->findOneByEmail();
                
                
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } else {
        }

        return $app['twig']->render('shoppingbydate.html.twig', [
            'searchForm' => $searchForm->createView(),
            'user' => $result,

        ]);
    }
    
     public function shoppingbystore(Request $request, Application $app)
    {
        
        
        $searchForm = $app['form.factory']->create(new ReportStoreType());
        $em = $app['orm.em'];
        
        $connection = $em->getConnection();
        $RAW_QUERY = 'SELECT id,name FROM Merchant Where active=1 order by name ASC';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $stores = $statement->fetchAll();
        
        $merchantid=$_GET['merchantid'];
        
        
        $searchForm->handleRequest($request);
         
        if ($searchForm->isValid()) {
            // search user
            try {
         
                $data = $searchForm->getData();
                $startdate=$data["startDate"];
                $enddate=$data["endDate"];
                
                if($startdate=="" || $enddate==""){
                    
                    $RAW_QUERY = 'SELECT  `a`. * ,  `p`.user_id AS user_id,  `m`.name AS merchant_name,  `u`.email AS user_email
                                FROM (
                                `AdvertiserTransaction` AS a
                                )
                                JOIN  `Merchant` AS m ON  `m`.`id` =  `a`.`merchant_id` 
                                JOIN  `Payable` AS p ON  `p`.`id` =  `a`.`cashback_id` 
                                JOIN  `user` AS u ON  `u`.`uid` =  `p`.`user_id` where a.merchant_id='.$merchantid;
                    
                }else{
                
                $starts = date("Y-m-d",strtotime($startdate->format('Y-m-d')));
                $ends = date("Y-m-d",strtotime($enddate->format('Y-m-d')));
                $where = "STR_TO_DATE(a.registeredAt, '%Y-%m-%d') between STR_TO_DATE('".$starts."',  '%Y-%m-%d') AND STR_TO_DATE('".$ends."', '%Y-%m-%d')";
                
                $RAW_QUERY = 'SELECT  `a`. * ,  `p`.user_id AS user_id,  `m`.name AS merchant_name,  `u`.email AS user_email
                                FROM (
                                `AdvertiserTransaction` AS a
                                )
                                JOIN  `Merchant` AS m ON  `m`.`id` =  `a`.`merchant_id` 
                                JOIN  `Payable` AS p ON  `p`.`id` =  `a`.`cashback_id` 
                                JOIN  `user` AS u ON  `u`.`uid` =  `p`.`user_id` where a.merchant_id='.$merchantid.' AND '.$where;
                //echo $RAW_QUERY; exit;
                }
                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $result = $statement->fetchAll();
                
                //$user = $em->getRepository('App\Entity\User')->findOneByEmail();
                
               
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } else {
        }
             

        return $app['twig']->render('shoppingbystore.html.twig', [
            'searchForm' => $searchForm->createView(),
            'store' => $stores,
            'user' => $result,

        ]);
    }
    
	 public function cashsearch(Application $app ,Request $request)
    {
		       $searchForm = $app['form.factory']->create(new ReportShoppingType());
        $em = $app['orm.em'];
        $data = $request->request->all();
      
       
       

      $edata=$data['email'];

	   $em = $app['orm.em'];
	   $connection = $em->getConnection();

     //  $dateform=['form']=$datef;
     //  $dateform=['form']=$dates;
//print_r($data); exit;
       

		
		  $RAW_QUERY = "SELECT  `p`. user_id,  SUM(`p`.available) AS count_available, SUM(`p`.pending) AS total_pending, SUM(`p`.processing) AS total_processing, SUM(`p`.paid) AS total_paid, `u`.email AS user_email
                        FROM (
                        `Payable` AS p
                         )
                        JOIN  `user` AS u ON  `u`.`uid` =  `p`.user_id 
                       WHERE  (p.available !='0.00' OR p.pending !='0.00' OR p.processing !='0.00' OR p.paid !='0.00') AND u.email= "."'".$edata."'"." AND p.user_id!='NULL'
                       GROUP BY user_id
                       ORDER BY `p`.`user_id`  ASC";
					

               	$statement = $connection->prepare($RAW_QUERY);
        		$statement->execute();
        		$cashbackuser = $statement->fetchAll();
		
         return $app['twig']->render('cashbackreport.html.twig', [
            'searchForm' => $searchForm->createView(),
            'cashbackuser' => $cashbackuser,
            'returnform' => $data,

        ]);
    }

    public function cashbackreport(Request $request, Application $app)
    {
        
        $searchForm = $app['form.factory']->create(new ReportShoppingType());
        $em = $app['orm.em'];
        $connection = $em->getConnection();
         $data['email']='';
        /*
        $RAW_QUERY = "SELECT  `p`. user_id,  SUM(`p`.available) AS count_available, SUM(`p`.pending) AS total_pending, SUM(`p`.processing) AS total_processing, SUM(`p`.paid) AS total_paid,  `u`.email AS user_email
                        FROM (
                        `Payable` AS p
                         )
                        JOIN  `user` AS u ON  `u`.`uid` =  `p`.user_id 
                       WHERE  p.status =  'available' AND p.available !='0.00' AND p.user_id!='NULL'
                       GROUP BY user_id
                       ORDER BY `p`.`user_id`  ASC";
         * 
         */
        //echo $RAW_QUERY; exit;
        $RAW_QUERY = "SELECT  `p`. user_id,  SUM(`p`.available) AS count_available, SUM(`p`.pending) AS total_pending, SUM(`p`.processing) AS total_processing, SUM(`p`.paid) AS total_paid, `u`.email AS user_email
                        FROM (
                        `Payable` AS p
                         )
                        JOIN  `user` AS u ON  `u`.`uid` =  `p`.user_id 
                       WHERE  (p.available !='0.00' OR p.pending !='0.00' OR p.processing !='0.00' OR p.paid !='0.00') AND p.user_id!='NULL'
                       GROUP BY user_id
                       ORDER BY `p`.`user_id`  ASC";
        
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $cashbackuser = $statement->fetchAll();
        
        
        $searchForm->handleRequest($request);
        if ($searchForm->isValid()) {
            // search user
            try {
                $data = $searchForm->getData();
                
                
                
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } else {
        }

        return $app['twig']->render('cashbackreport.html.twig', [
            'searchForm' => $searchForm->createView(),
            'cashbackuser' => $cashbackuser,
			 'returnform' => $data,

        ]);
    }
}
