<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use App\Form\UserSearchType;
use App\Form\UserReportType;
use App\Form\UserReferalType;
use App\Form\UserAccountType;
use App\Form\Model\UserAccount;
use App\Entity\User;

class UserInfoController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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
                //echo $startdate->format('Y-m-d');
                //echo $enddate->format('Y-m-d');
                //echo "<pre>"; print_r($data); exit;
                
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
                
                
                //echo "<pre>"; print_r($result); exit;
                //$user = $em->getRepository('App\Entity\User')->findOneByEmail();
                
                /*
                if ($user === null) {
                    
                    throw new \RuntimeException('User not found');
                }
                 * 
                 */
                /*
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
                 * 
                 */
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
