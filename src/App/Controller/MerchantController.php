<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityManager;
use App\Popshops\Merchant;

class MerchantController implements TwigInterface
{
    use TwigTrait;

    protected $em;
    protected $formFactory;

    public function __construct(EntityManager $em, FormFactory $factory)
    {
        $this->em = $em;
        $this->formFactory = $factory;
    }

    public function listMerchants()
    {
        $merchants = $this->em->getRepository('App\Popshops\Merchant')->findBy([], ['name' => 'ASC']);

        return new Response($this->render('merchant_list.html.twig', [
            'merchants' => $merchants,
        ]));
    }

    public function editMerchant($merchantId, Request $request)
    {
        $merchant = $this->em->find('App\Popshops\Merchant', $merchantId);

        $form = $this->formFactory->createBuilder('form', $merchant)
            ->setMethod('POST')
            ->add('cashbackRate', 'text', [
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('cashbackType', 'choice', [
                'choices' => [
                    Merchant::CASHBACK_TYPE_FIXED => ucfirst(Merchant::CASHBACK_TYPE_FIXED),
                    Merchant::CASHBACK_TYPE_PERCENTAGE => ucfirst(Merchant::CASHBACK_TYPE_PERCENTAGE),
                ],
                'constraints' => [new Assert\Choice([
                    Merchant::CASHBACK_TYPE_FIXED,
                    Merchant::CASHBACK_TYPE_PERCENTAGE,
                ])],
            ])
            ->getForm();

        $form->handleRequest($request);

        return new Response($this->render('merchant_edit.html.twig', [
            'merchant' => $merchant,
            'form' => $form->createView(),
        ]));
    }
}
