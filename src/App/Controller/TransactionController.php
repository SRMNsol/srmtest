<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Subid;
use App\Form\TransactionType;

class TransactionController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function editTransaction(Transaction $transaction, User $user, Request $request, Application $app)
    {
        $form = $app['form.factory']->create(new TransactionType(), $transaction);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $transaction = $form->getData();

            if (null === $transaction->getTag()) {
                $subid = new Subid();
                $subid->setUserId($user->getId());
                $transaction->setTag((string) $subid);
            }

            $transaction->setNetwork($transaction->getMerchant()->getNetwork());
        }

        return $app['twig']->render('transaction_edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
