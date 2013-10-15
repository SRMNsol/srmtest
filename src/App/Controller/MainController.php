<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;

class MainController implements TwigInterface
{
    use TwigTrait;

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function dashboard()
    {
        $merchants['total'] = $this->em->createQuery('SELECT COUNT(m) FROM App\Popshops\Merchant m')->getSingleScalarResult();
        $merchants['totalNoCashback'] = $this->em->createQuery('SELECT COUNT(m) FROM App\Popshops\Merchant m WHERE m.cashbackRate = 0')->getSingleScalarResult();

        return new Response($this->render('dashboard.html.twig', [
            'merchants' => $merchants,
        ]));
    }
}
