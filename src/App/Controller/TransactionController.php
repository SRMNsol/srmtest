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

    public function editTransaction(Transaction $transaction = null, User $user, Request $request, Application $app)
    {
        $form = $app['form.factory']->create(new TransactionType(), $transaction);

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $transaction = $form->getData();

                if (null === $transaction->getTag()) {
                    $subid = new Subid();
                    $subid->setUserId($user->getId());
                    $transaction->setTag((string) $subid);
                }

                if ($transaction->getMerchant() !== null) {
                    $transaction->setNetwork($transaction->getMerchant()->getNetwork());
                }

                $transaction->setManual(true);

                $this->em->persist($transaction);
                $this->em->flush();

                $app['session']->getFlashBag()->add('success', 'Transaction saved');

                return $app->redirect($app['url_generator']->generate('user_info', [
                    'user_search' => ['email' => $user->getEmail()]
                ]));
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', 'Update failed');
            }
        }

        return $app['twig']->render('transaction_edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    public function deleteTransaction(Transaction $transaction, User $user, Application $app)
    {
        try {
            $app['orm.em']->remove($transaction);
            $app['orm.em']->flush();
            $app['session']->getFlashBag()->add('success', 'Transaction deleted');
        } catch (\Exception $e) {
            $app['session']->getFlashBag()->add('danger', 'Delete failed');
        }

        return $app->redirect($app['url_generator']->generate('user_info', [
            'user_search' => ['email' => $user->getEmail()]
        ]));
    }
}
