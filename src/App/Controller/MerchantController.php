<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;

class MerchantController implements TwigInterface
{
    use TwigTrait;

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function listMerchants()
    {
        $merchants = $this->em->getRepository('App\Popshops\Merchant')->findBy([], ['name' => 'ASC']);

        return new Response($this->render('merchant_list.html.twig', [
            'merchants' => $merchants,
        ]));
    }

    public function editMerchant($merchantId)
    {
        $merchant = $this->em->find('App\Popshops\Merchant', $merchantId);

        return new Response($this->render('merchant_edit.html.twig', [
            'merchant' => $merchant,
        ]));
    }
}
