<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;

class MainController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function dashboard(Application $app)
    {
        $merchants['total'] = $this->em->createQuery('SELECT COUNT(m) FROM App\Entity\Merchant m')->getSingleScalarResult();
        $merchants['totalNoCashback'] = $this->em->createQuery('SELECT COUNT(m) FROM App\Entity\Merchant m WHERE m.commission = 0')->getSingleScalarResult();

        $networks = $this->em->createQuery('SELECT n FROM App\Entity\Network n JOIN n.merchants m GROUP BY n HAVING COUNT(m) > 0')->getResult();

        return new Response($app['twig']->render('dashboard.html.twig', [
            'merchants' => $merchants,
            'networks' => $networks,
        ]));
    }
}
