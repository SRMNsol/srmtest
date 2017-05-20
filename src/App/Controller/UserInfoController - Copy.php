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
use App\Entity\User;

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


    public function addform(Request $request,Application $app)
    {  

       return new Response($app['twig']->render('add_form.html.twig', [
            'pages' => $pages,

        ]));

    }

    public function pageadd(Request $request,Application $app)
    {
        $data = $request->request->all();
      
        $em = $app['orm.em'];
        $connection = $em->getConnection();

       $pagetitle=$data['title'];
       $pagedsc=$data['description'];
       $pagedate=$data['expiryDate'];

        $RAW_QUERY = 'INSERT INTO pages VALUES (null,'.'"'.$pagetitle.'"'.', '.'"'.$pagedsc.'"'.','.'"'.$pagedate.'"'.')';

        $statement = $connection->prepare($RAW_QUERY); 
         $statement->execute();
    
        return new Response($app['twig']->render('add_form.html.twig', [
            'pages' => $pages,

        ]));


    }

    public function updatepage(Request $request,Application $app)
    {  
        $data = $request->request->all();

       $pageid=$data['page'];
       $pagedsc=$data['description'];
       $pagedate=$data['expiryDate'];
       $pagetitle=$data['title'];

        $em = $app['orm.em'];
        $connection = $em->getConnection();
        
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
        $RAW_QUERY = 'SELECT * FROM Faqs';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $faqs = $statement->fetchAll();

      
         return new Response($app['twig']->render('faq_managment.html.twig', [
            'faqs' => $faqs,

        ]));
    }

    public function addfaq(Request $request, Application $app)
    {
         
         return new Response($app['twig']->render('faq_form.html.twig', [
            'faqs' => $faqs,

        ]));
    }

    public function faqadd(Request $request, Application $app)
    {
        
        $data = $request->request->all();
      
        $em = $app['orm.em'];
        $connection = $em->getConnection();

       $faqcat=$data['faq_cat'];
       $faqtitle=$data['title'];
       $faqdsc=$data['description'];

       $RAW_QUERY = 'INSERT INTO Faqs VALUES (null,'.'"'.$faqtitle.'"'.', '.'"'.$faqdsc.'"'.','.'"'.$faqcat.'")';

        $statement = $connection->prepare($RAW_QUERY); 
         $statement->execute();

        $RAW_QUERY = 'SELECT * FROM Faqs';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $faqs = $statement->fetchAll();

      
         return new Response($app['twig']->render('faq_managment.html.twig', [
            'faqs' => $faqs,


        ]));

    }


    public function faqdelete(Request $request,Application $app)
    {
        $data=$request->request->get('data');


        $em = $app['orm.em'];
        $connection = $em->getConnection();
       echo  $RAW_QUERY = 'DELETE  FROM Faqs WHERE faq_id= '.$data.'';
     exit();
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $merchants = $statement->fetchAll();
        
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
        $RAW_QUERY = 'SELECT * FROM Faqs WHERE faq_id= '.$faq_id.'';
     
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $faqs = $statement->fetchAll();

         return new Response($app['twig']->render('faq_edit.html.twig', [
            'faqs' => $faqs,
             'form' => $form->createView(),
           
        ]));
    }


    public function faqupdate(User $user = null ,Request $request, Application $app)
    {

        $data = $request->request->all();
       $faqid=$data['hidden'];
       $faqdsc=$data['faqDesc'];
       $faqCate=$data['faqCate'];
       $faqtitle=$data['faqName'];

        $em = $app['orm.em'];
        $connection = $em->getConnection();
        
        $RAW_QUERY = 'Update  Faqs SET faq_cate='.'"'.$faqCate.'"'.', faq_name='.'"'.$faqtitle.'"'.', faq_desc='.'"'.$faqdsc.'"'.' WHERE faq_id= '.'"'.$faqtitle.'"';

        $statement = $connection->prepare($RAW_QUERY); 
        $statement->execute();
      
        $RAW_QUERY = 'SELECT * FROM Faqs';
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
                
                $connection = $em->getConnection();
                $RAW_QUERY= "SELECT u.uid as userid , u.email AS useremail, us.uid AS refid ,us.email AS refemail from user AS u join user AS us ON us.`ref_uid` = u.uid
                            where u.email='".$data['email']."'";
                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $alluser = $statement->fetchAll();
				
				
                //echo  $data['email'].$RAW_QUERY;
                $arr=$alluser;
               foreach($arr as $key=>$value){
                   
                    $SQL = "SELECT email FROM `user` WHERE ref_uid='".$value['refid']."'";
                    $statement = $connection->prepare($SQL);
                    $statement->execute();
                    $refuser = $statement->fetchAll();
                    
                    $alluser[$key]['countref'] = count($refuser);
                }
                
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
                $where = "STR_TO_DATE(a.created, '%Y-%m-%d') between STR_TO_DATE('".$starts."',  '%Y-%m-%d') AND STR_TO_DATE('".$ends."', '%Y-%m-%d')";
               
                $connection = $em->getConnection();
                 
                $RAW_QUERY= "SELECT  a.*, b.email as referel_email
                            FROM user a, user b
                            WHERE a.ref_uid = b.uid
                            AND ".$where;
                //$RAW_QUERY = 'SELECT * FROM user where '.$where;
                $statement = $em->getConnection()->prepare($RAW_QUERY);
                $statement->execute();
                $result = $statement->fetchAll();
                
                
                
                
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } else {
        }

        return $app['twig']->render('user_report.html.twig', [
            'searchForm' => $searchForm->createView(),
            'user' => $result,
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
                
                
                $RAW_QUERY1 = "SELECT uid,email FROM user where alias='".$data['alias']."'";
                
                $statement = $connection->prepare($RAW_QUERY1);
                $statement->execute();
                $result2 = $statement->fetchAll();
                $id=$result2[0]['uid'];
                $refferedbyemail['refemail']=$refferedby=$result2[0]['email'];
                
                //echo "<pre>"; print_r(count($result2)); exit;
                
                if (count($result2) == 0) {
                    throw new \RuntimeException('Invalid Alias');
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
