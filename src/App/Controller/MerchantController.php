<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use App\Entity\Merchant;
use App\Form\MerchantType;

class MerchantController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function listMerchants(Application $app)
    {
        $merchants = $this->em->getRepository('App\Entity\Merchant')->findBy([], ['name' => 'ASC']);
        
        return new Response($app['twig']->render('merchant_list.html.twig', [
            'merchants' => $merchants,
        ]));
    }
    public function dateMerchants(Application $app)
    {
		$data['expiryfirst']='';
       	$data['expirysecond']='';
        $em = $app['orm.em'];
        $connection = $em->getConnection();
        $RAW_QUERY = 'SELECT expiryDate ,name, id FROM Merchant  WHERE expiryDate < CURDATE()';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $merchants = $statement->fetchAll();
         return new Response($app['twig']->render('merchant_date.html.twig', [
            'merchants' => $merchants,
			 'dataform' => $data,

        ]));
    }
 
    public function searchexp(Application $app ,Request $request)
    {

        $data = $request->request->all();
      
        $em = $app['orm.em'];
        $connection = $em->getConnection();
		

       $datef=$data['expiryfirst'];
       $dates=$data['expirysecond'];
     //  $dateform=['form']=$datef;
     //  $dateform=['form']=$dates;
//print_r($data); exit;
       
        $RAW_QUERY = 'SELECT expiryDate ,name, id FROM Merchant WHERE expiryDate >= '.'"'.$datef.'"'.' AND   expiryDate <='.'"'.$dates.'"';

        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $merchants = $statement->fetchAll();
         return new Response($app['twig']->render('merchant_date.html.twig', [
            'merchants' => $merchants,
            'dataform' => $data,
           

        ]));
    }



    public function expiryMerchant(Merchant $merchant = null, Request $request, Application $app)
    {  
	
       $form = $app['form.factory']->create(new MerchantType(), $merchant);
        $form->handleRequest($request);

        $mer_id= $merchant->getId();
      

        $em = $app['orm.em'];
        $connection = $em->getConnection();
        $RAW_QUERY = 'SELECT expiryDate ,id FROM Merchant WHERE id= '.$mer_id.'';
     
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $merchants = $statement->fetchAll();

         return new Response($app['twig']->render('merchant_expiry.html.twig', [
            'merchants' => $merchants,
             'form' => $form->createView(),
           
        ]));
    }


    public function updateMerchant(Merchant $merchant = null, Request $request, Application $app)
    {  
	
         $mer_id= $merchant->getId();
        $data = $request->request->all();

        $expdate=$data['expiryDate'];
		$dataform=[];
        $em = $app['orm.em'];
        $connection = $em->getConnection();

        $RAW_QUERY = 'Update  Merchant SET expiryDate='.'"'.$expdate.'"'.' WHERE id= '.$mer_id.'';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
      

        $RAW_QUERY = 'SELECT expiryDate ,name, id FROM Merchant WHERE expiryDate < CURDATE() ORDER BY expiryDate ASC';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $merchants = $statement->fetchAll();
         return new Response($app['twig']->render('merchant_date.html.twig', [
            'merchants' => $merchants,
          

        ]));

    }
    public function editMerchant(Merchant $merchant = null, Request $request, Application $app)
    {  
        $form = $app['form.factory']->create(new MerchantType(), $merchant);
        $form->handleRequest($request);

        $mer_idd= $merchant->getId();
        $data = $request->request->all();
         if(!empty($data)) {
          $categ=implode (',',$data['mcategory']);
      }
        

          if (!empty($data)) {

                $em = $app['orm.em'];
                $connection = $em->getConnection();

                $datecu=$data['expiryDate'];
                $RAW_QUERY = 'Update  Merchant SET expiryDate='.'"'.$datecu.'"'.' WHERE id= '.$mer_idd.'';
                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
            }

        if ($form->isValid()) {
            try {
                $merchant = $form->getData();
                $this->em->persist($merchant);


                $this->em->flush();
                $app['session']->getFlashBag()->add('success', 'Merchant updated');

                $mer_idd=$merchant->getId();


                $RAW_QUERY = 'Update  Merchant SET category_id='.'"'.$categ.'"'.' WHERE id= '.$mer_idd.'';

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();

                return $app->redirect($app['url_generator']->generate('merchant_edit', ['merchant' => $merchant->getId()]));
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', 'Update failed');
            }
        } elseif ($form->isSubmitted() && $merchant !== null && $this->em->contains($merchant)) {
            $this->em->refresh($merchant);
        }
                $em = $app['orm.em'];
                $connection = $em->getConnection();

                $RAW_QUERY = 'SELECT * From Category';
                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $categories = $statement->fetchAll();


                 $RAW_QUERY = 'SELECT category_id From Merchant  WHERE id= '.$mer_idd.'';
           
                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $catego = $statement->fetchAll();
              

                $ecategory=explode(',',$catego[0]['category_id']);





                $select='<select id="merchant_mcategory" name="mcategory[]" class="form-control selectpicker" multiple>';
                 
                 for ($i=0; $i <count($categories); $i++) {

                   $select.="<option value=".$categories[$i]['id'];



                        if (in_array($categories[$i]['id'], $ecategory)) {

                                $select.="    selected ";
                            
                            }


                   $select.= ">".$categories[$i]['name'];


                       


                     $select.="</option>"; 
                    
                 }

                $select.='</select>'; 






$editselect=0;

        return new Response($app['twig']->render('merchant_edit.html.twig', [
            'merchant' => $merchant,
            'form' => $form->createView(),
            'categories' => $categories,
            'ecategory' => $select,
            'editselect' => $editselect,
        ]));
        
    }

    public function createMerchant(Merchant $merchant = null, Request $request, Application $app)
    {  


        $form = $app['form.factory']->create(new MerchantType(), $merchant);
        $form->handleRequest($request);


         $data = $request->request->all();
         if(!empty($data)) {
          $categ=implode (',',$data['mcategory']);
      }
       //  echo '<>';
        // print_r($data ); exit;
         //print_r($data); exit;

       //  if($data)
        //    $categ=implode (',',$data['category'])
       //if($data) exit;


      //  $mer_idd= $merchant->getId();
       /*  $data = $request->request->all();
        

          if (!empty($data)) {

                $em = $app['orm.em'];
                $connection = $em->getConnection();

                $datecu=$data['expiryDate'];
                $RAW_QUERY = 'Update  Merchant SET expiryDate='.'"'.$datecu.'"'.' WHERE id= '.$mer_idd.'';
                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
            }
*/
        if ($form->isValid()) {
            try {
                $merchant = $form->getData();
                $this->em->persist($merchant);


                $this->em->flush();
                $app['session']->getFlashBag()->add('success', 'Merchant updated');

                if(!empty($data)){  

                $em = $app['orm.em'];
                $connection = $em->getConnection();


                $RAW_QUERY = 'SELECT MAX(id) as id From Merchant';
                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $categories = $statement->fetchAll();
                $mer_idd= $categories[0]['id']; 
               


                $RAW_QUERY = 'Update  Merchant SET category_id='.'"'.$categ.'"'.' WHERE id= '.$mer_idd.'';

                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
}

                return $app->redirect($app['url_generator']->generate('merchant_edit', ['merchant' => $merchant->getId()]));
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', 'Update failed');
            }
        } elseif ($form->isSubmitted() && $merchant !== null && $this->em->contains($merchant)) {
            $this->em->refresh($merchant);
        }
              //  $mer_idd= $merchant->getId();


            /*if($data)
              echo   $RAW_QUERY = 'Update  Merchant SET category_id='.'"'.$categ.'"'.' WHERE id= '.$mer_idd.'';
             if($data) exit;
                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();


*/
                $ecategory=0;

                $em = $app['orm.em'];
                $connection = $em->getConnection();

                $RAW_QUERY = 'SELECT * From Category';
                $statement = $connection->prepare($RAW_QUERY);
                $statement->execute();
                $categories = $statement->fetchAll();

        $editselect=1;

        return new Response($app['twig']->render('merchant_edit.html.twig', [
            'merchant' => $merchant,
            'form' => $form->createView(),
            'categories' => $categories,
             'ecategory' => $ecategory,
              'editselect' => $editselect,


        ]));
        
    }

    public function deleteMerchant(Merchant $merchant, Application $app)
    {
        try {
            $this->em->remove($merchant);
            $this->em->flush();
            $app['session']->getFlashBag()->add('success', sprintf('Merchant %s deleted', $merchant->getName()));
        } catch (ForeignKeyConstraintViolationException $e) {
            $app['session']->getFlashBag()->add('danger', sprintf('Merchant %s cannot be deleted because it has related transaction data', $merchant->getName()));
        } catch (\Exception $e) {
            $app['session']->getFlashBag()->add('danger', 'Delete failed');
        }

        return $app->redirect($app['url_generator']->generate('merchant_list'));
    }
}
