<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManager;
use App\Form\UserSearchType;
use App\Form\UserReportType;
use App\Form\UserReferalType;
use App\Form\UserAccountType;
use App\Form\Model\UserAccount;


use App\Entity\Mailin;




use App\Form\MerchantType;

use App\Form\ReportShoppingType;
use App\Form\ReportStoreType;




class UserInfoController
{
    protected $em;

/**
* @Route("/refcheck/{data}", name="refcheck")
*/

    public function __construct(EntityManager $em)
    {
		
       
       
        $this->em = $em;
    }
    /**                                                                                   
 * @Route("/refcheck", name="refcheck")
 */
 

  public function autopost(Request $request, Application $app)
    {

        $config = array();
        $config['appId'] = '117040755037895';
        $config['secret'] = '04ced89742cf2754a630775cdc956081';
        $config['fileUpload'] = false; // optional

        $em = $app['orm.em'];
        $connection = $em->getConnection();


        $RAW_QUERY = 'SELECT * FROM user WHERE uid="12452"';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $users = $statement->fetchAll();
         $fb_access_auto= $users[0]['fb_access_token'];

//print_r($fb_access_auto); exit;
        if($users[0]['facebook_auto']==1)
        {

        $data = array('payment' => '2.50', 'token_access' => $fb_access_auto);


             $url='http://dev.nsol.sg/projects/beesavy_new/Facebook.php';


           //$url='https://beesavy.com';



                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);

                 curl_setopt($ch, CURLOPT_POST, true);

                curl_setopt($ch, CURLOPT_POSTFIELDS,$data);


                $response  = curl_exec($ch);

                curl_close($ch);

                //echo curl_error($ch);

               // print_r($response); 
               exit();

        }

}


     public function backoffice(Request $request,Application $app)
    {

		$em = $app['orm.em'];
        $connection = $em->getConnection(); 
        $RAW_QUERY = 'SELECT * FROM user ORDER BY uid DESC limit 500';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $users = $statement->fetchAll();
		//print_r($users);
		//exit;


 return new Response($app['twig']->render('user_managment.html.twig', [
            'users' => $users,

        ]));
        		
    }

    public function popupcheck(Request $request,Application $app)
    {
        
        $data=$request->request->get('data');


        $em = $app['orm.em'];
        $connection = $em->getConnection();
   
  
        $RAW_QUERY = 'UPDATE user SET popup_status=:status WHERE uid = :id';

        $row_affected = $connection->executeUpdate($RAW_QUERY,array('id' => 10,'status' => $data));

        $RAW_QUERY = 'SELECT * FROM user WHERE uid=10';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $userinfod = $statement->fetchAll();
       // print_r($merchants);
        return 'Congrats! record has been updated successfully';
    }


    public function refcheck(Request $request,Application $app)
    {
		
		$data=$request->request->get('data');

    	$em = $app['orm.em'];
        $connection = $em->getConnection();
   
  
              $RAW_QUERY = 'UPDATE user SET referral_status=:status WHERE id = :id';

        $row_affected = $connection->executeUpdate($RAW_QUERY,array('id' => 157476,'status' => $data));




        $RAW_QUERY = 'SELECT * FROM user WHERE id=157476';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
		$userinfod = $statement->fetchAll();
       // print_r($merchants);
		return 'Congrats! record has been updated successfully';
	}



  

    public function refralbonus(Request $request, Application $app)
    {
        $em = $app['orm.em'];
        $connection = $em->getConnection();
        $RAW_QUERY = 'SELECT * FROM user';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $users = $statement->fetchAll();
      
         return new Response($app['twig']->render('bonus_managment.html.twig', [
            'users' => $users,

        ]));
    }


    public function userstatus(Request $request,Application $app)
    {
		

        $userid=$request->request->get('userid');
        $status=$request->request->get('status');
       

        $em = $app['orm.em'];
        $connection = $em->getConnection();
		
		
		
		 $RAW_QUERY = 'Update  user SET status='.'"'.$status.'"'.' WHERE uid= '.$userid.'';

        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
       
 
		
		 $RAW_QUERY = 'SELECT * FROM user WHERE uid='.$userid.'';
      
		$statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $users = $statement->fetchAll();
		
		
		$user_email=$users[0]['email'];
		
		
		if($status=='inactive')
		{
		
			$url='http://dev.nsol.sg/projects/beesavy_new/Mailin.php';

             $data = array('email' => $user_email);

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);

                curl_setopt($ch, CURLOPT_POST, true);

                curl_setopt($ch, CURLOPT_POSTFIELDS,$data);


                $response  = curl_exec($ch);
                exit;
		

		}
  
       
        $RAW_QUERY = 'SELECT * FROM user';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $users = $statement->fetchAll();
      
         return new Response($app['twig']->render('user_managment.html.twig', [
            'users' => $users,

        ]));
    }

    public function bonusstatus(Request $request,Application $app)
    {
        $userid=$request->request->get('userid');
        $status=$request->request->get('status');
       

        $em = $app['orm.em'];
        $connection = $em->getConnection();
  
     $RAW_QUERY = 'Update user SET bonus='.'"'.$status.'"'.' WHERE uid= '.$userid.'';

        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        
        $RAW_QUERY = 'SELECT * FROM user';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $users = $statement->fetchAll();
      
         return new Response($app['twig']->render('bonus_managment.html.twig', [
            'users' => $users,

        ]));
    }

    public function bonusthems(Request $request,Application $app)
    {
        $userid=$request->request->get('userid');
        $status=$request->request->get('status');
       

        $em = $app['orm.em'];
        $connection = $em->getConnection();
  
     $RAW_QUERY = 'Update  user SET bonus_thems='.'"'.$status.'"'.' WHERE uid= '.$userid.'';

        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        
        $RAW_QUERY = 'SELECT * FROM user';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $users = $statement->fetchAll();
      
         return new Response($app['twig']->render('bonus_managment.html.twig', [
            'users' => $users,

        ]));
    }


    public function addform(Request $request,Application $app)
    {  

       return new Response($app['twig']->render('add_form.html.twig', [
            'pages' => $pages,

        ]));

    }

    public function pageadd(Request $request,Application $app)
    {
		
        $data = $request->request->all();
		//echo '<pre>';
		//print_r($data); exit;
      
        $em = $app['orm.em'];
        $connection = $em->getConnection();

       $pagetitle=$data['title'];
       $pageold=$data['description'];
	   
	  
	    $pagedsc = str_replace('"',"'", $pageold);
	
	   
	  
	
	  
    

    $RAW_QUERY = 'INSERT INTO pages VALUES (null,'.'"'.$pagetitle.'"'.', '.'"'.$pagedsc.'"'.','.'"'.$pagedate.'"'.')';

        $statement = $connection->prepare($RAW_QUERY); 
         $statement->execute();
    
        return new Response($app['twig']->render('add_form.html.twig', [
            'pages' => $pages,

        ]));


    }

    public function updatepage(Request $request,Application $app)
    {         $data = $request->request->all();

       $pageid=$data['page'];
       $pageold=$data['description'];
       $pagedate=$data['expiryDate'];
       $pagetitle=$data['title'];

        $em = $app['orm.em'];
        $connection = $em->getConnection();
        
		
		 $pagedsc = str_replace('"',"'", $pageold);
		
        $RAW_QUERY = 'Update  pages SET page_date='.'"'.$pagedate.'"'.', page_name='.'"'.$pagetitle.'"'.', page_desc='.'"'.$pagedsc.'"'.' WHERE page_id= '.$pageid.'';

         $RAW_QUERY = 'Update  pages SET page_date='.'"'.$pagedate.'"'.', page_name='.'"'.$pagetitle.'"'.', page_desc='.'"'.$pagedsc.'"'.' WHERE page_id= '.$pageid.'';

        $statement = $connection->prepare($RAW_QUERY); 
        $statement->execute();
      

         $RAW_QUERY = 'SELECT * FROM pages';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $pages = $statement->fetchAll();
      
         return new Response($app['twig']->render('cms_managment.html.twig', [
            'pages' => $pages,

        ]));

    }


    public function ajaxdesc(Request $request,Application $app)
    {
        $data=$request->request->get('data');


        $em = $app['orm.em'];
        $connection = $em->getConnection();
        $RAW_QUERY = 'SELECT * FROM pages WHERE page_id= '.$data.'';
     
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $merchants = $statement->fetchAll();
    	
		$response = new Response(json_encode(array('page' => $merchants[0])));
		$response->headers->set('Content-Type', 'application/json');
		return $response;	
    }



    public function faq(Request $request, Application $app)
    {

        $em = $app['orm.em'];
        $connection = $em->getConnection();
        $RAW_QUERY = 'SELECT * FROM Faqs INNER JOIN Faq_cate ON Faqs.faq_cate=Faq_cate.cate_id; ';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $faqs = $statement->fetchAll();

         return new Response($app['twig']->render('faq_managment.html.twig', [
            'faqs' => $faqs,

        ]));
    }

    public function addfaq(Request $request, Application $app)
    {
          $em = $app['orm.em'];
        $connection = $em->getConnection();
        $RAW_QUERY = 'SELECT * FROM Faq_cate';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $category = $statement->fetchAll();

         return new Response($app['twig']->render('faq_form.html.twig', [
            'category' => $category,

        ]));
    }

    public function faqadd(Request $request, Application $app)
    {
        
        $data = $request->request->all();
      
        $em = $app['orm.em'];
        $connection = $em->getConnection();

       $faqcat=$data['faq_cat'];
       $faqtitle=$data['title'];
       $pageold=$data['description'];
	   
	   $faqdsc = str_replace('"',"'", $pageold);
	   

       $RAW_QUERY = 'INSERT INTO Faqs VALUES (null,'.'"'.$faqtitle.'"'.', '.'"'.$faqdsc.'"'.','.'"'.$faqcat.'")';

        $statement = $connection->prepare($RAW_QUERY); 
         $statement->execute();

        $RAW_QUERY = 'SELECT * FROM Faqs INNER JOIN Faq_cate ON Faqs.faq_cate=Faq_cate.cate_id';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $faqs = $statement->fetchAll();

      
         return new Response($app['twig']->render('faq_managment.html.twig', [
            'faqs' => $faqs,


        ]));

    }


   
    public function faqedit(User $user = null ,Request $request, Application $app)
    {

        $form = $app['form.factory']->create(new MerchantType(), $UserInfo);
        $form->handleRequest($request);


        $url = $request->getUri();
        $tokens = explode('/', $url);
        $faq_id=$tokens[sizeof($tokens)-1];
   
        $em = $app['orm.em'];
        $connection = $em->getConnection();
       
        $RAW_QUERY = 'SELECT * FROM Faqs INNER JOIN Faq_cate ON Faqs.faq_cate=Faq_cate.cate_id WHERE faq_id= '.$faq_id.'';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $faqs = $statement->fetchAll();
       
        $RAW_QUERY = 'SELECT * FROM Faq_cate';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $category = $statement->fetchAll();


         return new Response($app['twig']->render('faq_edit.html.twig', [
            'faqs' => $faqs,
            'category' => $category,
             'form' => $form->createView(),
           
        ]));
    }



  public function faqupdelete(Request $request, Application $app)
    {
        $url = $request->getUri();
        $tokens = explode('/', $url);
        $faq_id=$tokens[sizeof($tokens)-1];

        $em = $app['orm.em'];
        $connection = $em->getConnection();
        $RAW_QUERY = 'DELETE  FROM Faqs WHERE faq_id= '.$faq_id.'';

        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        
       $RAW_QUERY = 'SELECT * FROM Faqs INNER JOIN Faq_cate ON Faqs.faq_cate=Faq_cate.cate_id';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $faqs = $statement->fetchAll();


      
         return new Response($app['twig']->render('faq_managment.html.twig', [
            'faqs' => $faqs,


        ]));
    }

    public function faqupdate(User $user = null ,Request $request, Application $app)
    {
        $data = $request->request->all();
       $faqid=$data['hidden'];
       $faqold=$data['faqDesc'];
       $faqCate=$data['faqCate'];
       $faqtitle=$data['faqName'];
	   
	   $faqdsc = str_replace('"',"'", $faqold);

        $em = $app['orm.em'];
        $connection = $em->getConnection();
        
        $RAW_QUERY = 'Update  Faqs SET faq_cate='.'"'.$faqCate.'"'.', faq_name='.'"'.$faqtitle.'"'.', faq_desc='.'"'.$faqdsc.'"'.' WHERE faq_id= '.'"'.$faqid.'"';

        $statement = $connection->prepare($RAW_QUERY); 
        $statement->execute();
      
         $RAW_QUERY = 'SELECT * FROM Faqs INNER JOIN Faq_cate ON Faqs.faq_cate=Faq_cate.cate_id';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $faqs = $statement->fetchAll();

      
         return new Response($app['twig']->render('faq_managment.html.twig', [
            'faqs' => $faqs,

        ]));
    }

    public function faqdelete(Request $request, Application $app)
    {

        $em = $app['orm.em'];
        $connection = $em->getConnection();
        $RAW_QUERY = 'SELECT * FROM Faqs';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $faqs = $statement->fetchAll();

      
         return new Response($app['twig']->render('faq_managment.html.twig', [
            'faqs' => $faqs,

        ]));
    }

    public function cms(Request $request, Application $app)
    {
        $em = $app['orm.em'];
        $connection = $em->getConnection();
        $RAW_QUERY = 'SELECT * FROM pages';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $pages = $statement->fetchAll();
      
         return new Response($app['twig']->render('cms_managment.html.twig', [
            'pages' => $pages,

        ]));
    }



    public function display(Request $request, Application $app)
    {
		
        $searchForm = $app['form.factory']->create(new UserSearchType());
        $em = $app['orm.em'];
        $totalCashback = 0.00;
        $totalSpending = 0.00;
        $totalPayment = 0.00;
        $totalReferral = 0.00;
        $totalExtraCashback = 0.00;
        $cashbackList = [];
        $user = null;

        $searchForm->handleRequest($request);
        if ($searchForm->isValid()) {
            // search user
            try {
                $data = $searchForm->getData();
				$edate='';
				$sdat='';
			if($data['startDate'])
			 $sdate=	$data['startDate']->format('Y-m-d');
			 if($data['endDate'])
			 $edate=	$data['endDate']->format('Y-m-d');
			
				
			
			$newdate['sfirstdate']=$sdate;
			$newdate['senddate']=$edate;
			if($data['email']=='')
			if($data['startDate']!='' OR $data['endDate']!='' )
			{
				 $connection = $em->getConnection();
				 $RAW_QUERY= "SELECT * FROM user AS u where DATE(u.created) >= "."'".$sdate."'"." AND  DATE(u.created) <="."'".$edate."' OR u.email='".$data['email']."'";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $dateuser = $statement->fetchAll();
				
				
				$RAW_QUERY= "SELECT u.email , u.uid as userid, u.last_cashback as cashback , us.uid AS refid ,us.email AS refemail from user AS u join user AS us ON us.`ref_uid` = u.uid where  DATE(u.created) >= "."'".$sdate."'"." AND  DATE(u.created) <="."'".$edate."' OR u.email='".$data['email']."'";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $newreffral = $statement->fetchAll();
				
				
				$RAW_QUERY= "SELECT * FROM user AS u where purchase_exempt=1";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $shoping = $statement->fetchAll();
				
				
				 return $app['twig']->render('search_active.html.twig', [
				  'searchForm' => $searchForm->createView(),
				'dateuser' => $dateuser,
				'shoping' => $shoping,
				 'dataform' => $newdate,
				 'newreffral' => $newreffral,
        ]);
				
			}
			
		

			
 $connection = $em->getConnection();
  $RAW_QUERY= "SELECT u.uid as userid , u.last_cashback as cashback , u.email AS useremail, us.uid AS refid ,us.email AS refemail from user AS u join user AS us ON us.`ref_uid` = u.uid where  DATE(u.created) >= "."'".$sdate."'"." AND  DATE(u.created) <="."'".$edate."' OR u.email='".$data['email']."'";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $alluser = $statement->fetchAll();
				
				
				$RAW_QUERY= "SELECT DISTINCT  name FROM Merchant ORDER BY name";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $allmerchant = $statement->fetchAll();
				

                $arr=$alluser;
                $newarr=$alluser;



               foreach($arr as $key=>$value){
                   
                    $SQL = "SELECT email FROM `user` WHERE ref_uid='".$value['refid']."'";
                    $statement = $connection->prepare($SQL);
                    $statement->execute();
                    $refuser = $statement->fetchAll();
                    $alluser[$key]['countref'] = count($refuser);
					
					 $SQL = "SELECT SUM(amount) as cashback FROM Payable WHERE user_id='".$value['refid']."' AND payableType='cashback'";
                    $statement = $connection->prepare($SQL);
                    $statement->execute();
                    $refuser = $statement->fetchAll();
					if($refuser[0]['cashback'] > 0 AND !empty($refuser[0]['cashback']))
						$alluser[$key]['cashback'] = $refuser[0]['cashback'];
					else
						$alluser[$key]['cashback'] = 0.0;
					
                    
                }
				
				
				
				

                $RAW_QUERY= "SELECT uid  FROM user WHERE email='".$data['email']."'";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $email_id = $statement->fetchAll();

                $user_cashback_id=$email_id[0]['uid'];


              $RAW_QUERY= "SELECT SUM(amount) as cashback FROM Payable WHERE user_id='".$user_cashback_id."' AND payableType='cashback'";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $usertotalCashback = $statement->fetchAll();
               
                
             	
				
                $user = $em->getRepository('App\Entity\User')->findOneByEmail($data['email']);
                if ($user === null) {
                    throw new \RuntimeException('User not found');
                }

   $cashbackList = $em->getRepository('App\Entity\Cashback')->findCashbackForUserByDateRange($user, $data['startDate'], $data['endDate'], 'latest');
                foreach ($cashbackList as $cashback) {
                    $totalCashback += $cashback->getAmount();
                    $totalSpending += $cashback->getTotalPurchase();
                    $totalPayment += $cashback->getPaid();
                }
				//print_r($cashbackList); exit;

                $referralList = $em->getRepository('App\Entity\Referral')->findReferralForUserByMonthRange(
                    $user,
                    $data['startDate'] instanceof \DateTime ? $data['startDate']->format('Ym') : null,
                    $data['endDate'] instanceof \DateTime ? $data['endDate']->format('Ym') : null
                );
                foreach ($referralList as $referral) {
                    $totalReferral += $referral->getAmount();
                    $totalPayment += $referral->getPaid();
                }

                $extraCashbackList = $em->getRepository('App\Entity\Payable')->findExtraCashbackForUserByDateRange($user, $data['startDate'], $data['endDate']);
                foreach ($extraCashbackList as $extraCashback) {
                    $totalExtraCashback += $extraCashback->getAmount();
                    $totalPayment += $extraCashback->getPaid();
                }
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } else {
        }

		
		// Level wise list of users
		 $connection = $em->getConnection();
		$RAW_QUERY= "SELECT u.uid as userid , u.email AS useremail, us.uid AS refid 
		,us.email AS refemail from user AS u 
		 join Payable AS p ON u.uid = p.user_id
		join user AS us ON us.`ref_uid` = u.uid
                            where u.email='".$data['email']."' GROUP BY u.email";
				$statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $level_two_users = $statement->fetchAll();
               foreach($level_two_users as $key=>$value){
                   
                    $SQL = "SELECT email FROM `user` WHERE ref_uid='".$value['refid']."'";
                    $statement = $connection->prepare($SQL);
                    $statement->execute();
                    $refuser = $statement->fetchAll();
                    
                    $level_two_users[$key]['countref'] = count($refuser);
                }
				
				
		 $connection = $em->getConnection();
		$RAW_QUERY= "SELECT u.uid as userid , u.email AS useremail, us.uid AS refid 
		,us.email AS refemail from user AS u 
		join user AS us ON us.`ref_uid` = u.uid
		 join Payable AS p ON  p.user_id = us.uid
                            where u.email='".$data['email']."' AND p.direct >= 5 AND p.payableType = 'referral' GROUP BY us.email";
				$statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $level_four_users = $statement->fetchAll();
             foreach($level_four_users as $key=>$value){
                   
                    $SQL = "SELECT email FROM `user` WHERE ref_uid='".$value['refid']."'";
                    $statement = $connection->prepare($SQL);
                    $statement->execute();
                    $refuser = $statement->fetchAll();
                    
                    $level_four_users[$key]['countref'] = count($refuser);
                }
		
        return $app['twig']->render('user_info.html.twig', [
            'searchForm' => $searchForm->createView(),
            'user' => $user,
            'cashbackList' => $cashbackList,
            'totalSpending' => $totalSpending,
            'totalCashback' => $totalCashback,
            'totalReferral' => $totalReferral,
            'totalPayment' => $totalPayment,
            'totalExtraCashback' => $totalExtraCashback,
            'totalEarning' => $totalCashback + $totalReferral + $totalExtraCashback,
            'alluser' => $alluser,
            'level_two_users' => $level_two_users,
            'level_two_users_count' => count($level_two_users),
            'level_four_users_count' => count($level_four_users),
            'level_four_users' => $level_four_users,
            'allmerchant' => $allmerchant,
            'usertotalCashback' => $usertotalCashback,
        ]);
    }

    public function edit($userId, Request $request, Application $app)
    {   
        $user = $app['orm.em']->find('App\Entity\User', $userId);

        if ($user === null) {
            return $app->abort(404, 'Invalid user id');
        }

        $account = new UserAccount();
        $account->setUser($user);
        if ($user->getReferredBy() !== null) {
            $account->setReferrerEmail($user->getReferredBy()->getEmail());
        }

        $form = $app['form.factory']->create(new UserAccountType(), $account, ['em' => $app['orm.em']]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $account = $form->getData();
                $user = $account->getUser();

                // processing password
                if ($account->getEditPassword() === true) {
                    $user->setPassword(User::passwordHash($account->getNewPassword()));
                }

                // processing referral
                $currentReferrerEmail = ($user->getReferredBy() !== null) ? $user->getReferredBy()->getEmail() : null;
                if ($account->getReferrerEmail() !== $currentReferrerEmail) {
                    if ($account->getReferrerEmail() === null) {
                        $user->setReferredBy(); // nullify
                    } else {
                        $referrer = $app['orm.em']->getRepository('App\Entity\User')->findOneByEmail($account->getReferrerEmail());
                        if ($referrer !== null) {
                            $user->setReferredBy($referrer);
                        }
                    }
                }

                $app['orm.em']->flush();

                $app['session']->getFlashBag()->add('success', 'User data updated');

                return $app->redirect($app['url_generator']->generate('user_edit', ['userId' => $userId]));

            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', sprintf('User update failed. %s', $e->getMessage()));
            }
        }

        return $app['twig']->render('user_edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
    
    public function report(Request $request, Application $app)
    {   
	
	
        $searchForm = $app['form.factory']->create(new UserReportType());
        $em = $app['orm.em'];
        $totalCashback = 0.00;
        $totalSpending = 0.00;
        $totalPayment = 0.00;
        $totalReferral = 0.00;
        $totalExtraCashback = 0.00;
        $cashbackList = [];
        $user = null;

        $searchForm->handleRequest($request);
        if ($searchForm->isValid()) {
            // search user
            try {
                $data = $searchForm->getData();
                $startdate=$data["startDate"];
                $enddate=$data["endDate"];
                
                $starts = date("Y-m-d",strtotime($startdate->format('Y-m-d')));
                $ends = date("Y-m-d",strtotime($enddate->format('Y-m-d')));
$where = "STR_TO_DATE(a.created, '%Y-%m-%d') between STR_TO_DATE('".$starts."',  '%Y-%m-%d') AND STR_TO_DATE('".$ends."', '%Y-%m-%d') ORDER BY uid DESC";
               
                $connection = $em->getConnection();
                 
                 $RAW_QUERY= "SELECT  a.*, b.email as referel_email
                            FROM user a, user b
                            WHERE a.ref_uid = b.uid
                            AND ".$where ;
							
                //$RAW_QUERY = 'SELECT * FROM user where '.$where;
                $statement = $em->getConnection()->prepare($RAW_QUERY);
                $statement->execute();
                $result = $statement->fetchAll();
                
              $RAW_QUERY= "SELECT u.email , u.uid as userid, u.last_cashback as cashback , us.uid AS refid ,us.email AS refemail from user AS u join user AS us ON us.`ref_uid` = u.uid where  DATE(u.created) >= "."'".$starts."'"." AND  DATE(u.created) <="."'".$ends."' OR u.email='".$data['email']."'";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $newreffral = $statement->fetchAll();
				
				
				
				$RAW_QUERY= "SELECT * FROM user AS u where purchase_exempt=1";

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $shoping = $statement->fetchAll();
                
                
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } else {
        }

        return $app['twig']->render('user_report.html.twig', [
            'searchForm' => $searchForm->createView(),
            'user' => $result,
			
			'shoping' => $shoping,
			'newreffral' => $newreffral,
//            'cashbackList' => $cashbackList,
//            'totalSpending' => $totalSpending,
//            'totalCashback' => $totalCashback,
//            'totalReferral' => $totalReferral,
//            'totalPayment' => $totalPayment,
//            'totalExtraCashback' => $totalExtraCashback,
//            'totalEarning' => $totalCashback + $totalReferral + $totalExtraCashback,
        ]);
    }
    
    public function getallreferal(Request $request, Application $app)
    {   
	
        $searchForm = $app['form.factory']->create(new UserReferalType());
        $em = $app['orm.em'];
        //$result2 = null;
           
        $searchForm->handleRequest($request);
        if ($searchForm->isValid()) {
            // search user
            try {
                $data = $searchForm->getData();
				
                
                
                $connection = $em->getConnection();
                
                /*
                $RAW_QUERY= "SELECT  a.*, b.email as referel_email
                            FROM user a, user b
                            WHERE a.ref_uid = b.uid
                            AND ".$where;
                 * 
                 */
                
                
                $RAW_QUERY1 = "SELECT uid,email FROM user where email='%".$data['email']."%' OR alias='".$data['alias']."'";
              
                $statement = $connection->prepare($RAW_QUERY1);
                $statement->execute();
                $result2 = $statement->fetchAll();
				
                 $id=$result2[0]['uid'];
                $refferedbyemail['refemail']=$refferedby=$result2[0]['email'];
				
            
                //echo "<pre>"; print_r(count($result2)); exit;
                
                if (count($result2) == 0) {
                    throw new \RuntimeException('Invalid Alias Or Email');
                }
                
                
                $RAW_QUERY = 'SELECT * FROM user where ref_uid='.$id;
                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $result = $statement->fetchAll();
                
                
                
            } catch (\Exception $e) {
				
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } else {
        }

        return $app['twig']->render('allreferal.html.twig', [
            'searchForm' => $searchForm->createView(),
            'user' => $result,
            'refferedbyemail' => $refferedbyemail,

        ]);
    }
}
