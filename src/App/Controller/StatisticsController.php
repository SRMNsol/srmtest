<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use App\Form\DateRangeType;

class StatisticsController
{
    protected $em; 

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    

   public function display(Request $request, Application $app)
    {
		

            

        $dateForm = $app['form.factory']->create(new DateRangeType());
		

        $params = [];
        $display = false;




        $dateForm->handleRequest($request);

        

        if ($dateForm->isValid()) {

            $display = true;
            $query = $dateForm->getData() + [
                'sort' => $request->get('sort', 'commission'),
                'dir' => $request->get('dir', 'desc'),
            ];


             if($_GET['newid']==1) {

        $em = $app['orm.em'];
        $connection = $em->getConnection();
        
                   $params['start_date'] = $query['start_date'];
                    $params['end_date'] = $query['end_date'];



                    if($query['start_date'])
                      $new_sdate= $query['start_date']->format('Y-m-d');
    
                     if($query['end_date'])
                     $new_edate=    $query['end_date']->format('Y-m-d');




                $RAW_QUERY= "SELECT * FROM user AS u where DATE(u.created) >= "."'".$new_sdate."'"." AND  DATE(u.created) <="."'".$new_edate."'";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $neweuser = $statement->fetchAll();

      
         return new Response($app['twig']->render('newstatistics.html.twig', [
            'neweuser' => $neweuser,

        ]));
}


             if($_GET['refid']==1) {

                    $em = $app['orm.em'];
                    $connection = $em->getConnection();
        
                   $params['start_date'] = $query['start_date'];
                    $params['end_date'] = $query['end_date'];



                    if($query['start_date'])
                       $ref_sdate= $query['start_date']->format('Y-m-d');
    
                     if($query['end_date'])
                     $ref_edate=    $query['end_date']->format('Y-m-d');

     $userRepo = $app['orm.em']->getRepository('App\Entity\User');        
                $params['total_referrers'] = $userRepo->getTotalReferrersList($query['start_date'], $query['end_date']);
                   
                //  echo '<pre>';
                 //  print_r($params['total_referrers']);exit;
               
/*
                 $RAW_QUERY= "SELECT u.email , u.uid as userid, u.last_cashback as cashback , us.uid AS refid ,us.email AS refemail from user AS u join user AS us ON us.`ref_uid` = u.uid where  DATE(u.created) >= "."'".$ref_sdate."'"." AND  DATE(u.created) <="."'".$ref_edate."'";


                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $refeuser = $statement->fetchAll();
               */
      
         return new Response($app['twig']->render('refstatistics.html.twig', [
            'refeuser' => $params['total_referrers'],

        ]));
}

             if($_GET['cashid']==1) {

                    $em = $app['orm.em'];
                    $connection = $em->getConnection();
        
                   $params['start_date'] = $query['start_date'];
                    $params['end_date'] = $query['end_date'];



                    if($query['start_date'])
                       $cash_sdate= $query['start_date']->format('Y-m-d');
    
                     if($query['end_date'])
                     $cash_edate=    $query['end_date']->format('Y-m-d');


 //$SQL = "SELECT SUM(amount) as cashback FROM Payable WHERE user_id='".$value['refid']."' AND payableType='cashback'";

                $RAW_QUERY= "SELECT u.email , u.uid as userid ,cash.amount as cashback from user AS u  join Payable AS cash ON cash.`user_id` = u.uid where 
                 cash.payableType='cashback' AND DATE(u.created) >= "."'".$cash_sdate."'"." AND  DATE(u.created) <="."'".$cash_edate."'";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $cashuser = $statement->fetchAll(); 
              /*      $cashbackRepo = $app['orm.em']->getRepositorylist('App\Entity\Cashback');
            $params['total_cashback'] = $cashbackRepo->getTotalCashback($query['start_date'], $query['end_date']);
echo '<pre>';
            print_r( $params['total_cashback']); exit;
               */
      
         return new Response($app['twig']->render('cashstatistics.html.twig', [
            'cashuser' => $cashuser,

        ]));
}
				
            $userRepo = $app['orm.em']->getRepository('App\Entity\User');
            $cashbackRepo = $app['orm.em']->getRepository('App\Entity\Cashback');
            $params['total_cashback'] = $cashbackRepo->getTotalCashback($query['start_date'], $query['end_date']);
            $params['total_shoppers'] = $userRepo->getTotalShoppers($query['start_date'], $query['end_date']);
            $params['total_new_users'] = $userRepo->getTotalNewUsers($query['start_date'], $query['end_date']);
            $params['total_referrers'] = $userRepo->getTotalReferrers($query['start_date'], $query['end_date']);
            $params['top_users'] = $userRepo->getTopUsers($query['start_date'], $query['end_date'], $query['sort'], $query['dir']);

            $params['start_date'] = $query['start_date'];
            $params['end_date'] = $query['end_date'];
            $params['sort'] = $query['sort'];
            $params['dir'] = $query['dir'];
        }
				
			if($query['start_date'])
			$sdate=	$query['start_date']->format('Y-m-d');
	
			 if($query['end_date'])
			 $edate=	$query['end_date']->format('Y-m-d');
		 
			$fsdate = date("Y-m-d", strtotime("-1 months")); 
			$fedate=date("Y-m-d"); 
		if($_GET['hiddenid']==1) {
			
			if($sdate==$fsdate)
			if($edate==$fedate)
			{
				
				
			return $app['twig']->render('activestatistics.html.twig', [
            'date_form' => $dateForm->createView(),
            'display' => $display,
        ] + $params);
			}
			}

			
        return $app['twig']->render('statistics.html.twig', [
            'date_form' => $dateForm->createView(),
            'display' => $display,
        ] + $params);
    }
	
}
