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

    public function editMerchant($merchantId = null, Request $request, Application $app)
    {
        $merchant = null === $merchantId ? new Merchant() : $this->em->find('App\Entity\Merchant', $merchantId);
        $form = $app['form.factory']->create(new MerchantType(), $merchant);

        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $merchant = $form->getData();
                $this->em->persist($merchant);
                $this->em->flush();
                $app['session']->getFlashBag()->add('success', 'Merchant updated');
                return $app->redirect($app['url_generator']->generate('merchant_edit', ['merchantId' => $merchant->getId()]));
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', 'Update failed');
            }
        } elseif ($this->em->contains($merchant)) {
            $this->em->refresh($merchant);
        }

        return new Response($app['twig']->render('merchant_edit.html.twig', [
            'merchant' => $merchant,
            'form' => $form->createView(),
        ]));
    }

    public function deleteMerchant($merchantId, Application $app)
    {
        $merchant = $this->em->find('App\Entity\Merchant', $merchantId);
        try {
            $merchantName = $merchant->getName();
            $this->em->remove($merchant);
            $this->em->flush();
            $app['session']->getFlashBag()->add('success', sprintf('Merchant %s deleted', $merchantName));
        } catch (ForeignKeyConstraintViolationException $e) {
            $app['session']->getFlashBag()->add('danger', sprintf('Merchant %s cannot be deleted because it has related transaction data', $merchantName));
        } catch (\Exception $e) {
            $app['session']->getFlashBag()->add('danger', 'Delete failed');
        }

        return $app->redirect($app['url_generator']->generate('merchant_list'));
    }
}
