<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ReferralRepository extends EntityRepository
{
    public function getMostRecentUserReferral(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->where('r.user = :user')
            ->orderBy('r.availableAt', 'DESC')
            ->setParameter('user', $user)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function calculateUserSummary(User $user)
    {
        $qb = $this->createQueryBuilder('r')
            ->select([
                'SUM(r.amount) AS amount',
                'SUM(r.pending) AS pending',
                'SUM(r.available) AS available',
                'SUM(r.processing) AS processing',
                'SUM(r.paid) AS paid'
            ])
            ->where('r.user = :user')
            ->groupBy('r.user')
            ->setParameter('user', $user)
        ;

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function calculateUserReferral(User $user, \DateTime $from, \DateTime $to, $level = 7)
    {
        $em = $this->getEntityManager();
        $cashbackRepository = $em->getRepository('App\Entity\Cashback');

        $commission = 0.00;
        $available = 0.00;
        $registeredAt = null;
        $direct = 0.00;
        $indirect = 0.00;

        $tree = $user->getReferralTree($level);
        foreach ($tree as $level => $children) {
            foreach ($children as $child) {
                $cashbacks = $cashbackRepository->findCashbackForUserByDateRange($child, $from, $to);

                foreach ($cashbacks as $cashback) {
                    $values = $cashback->calculateTransactionValues($level);

                    $commission += $values['commission'];
                    if ($cashback->getStatus() === Cashback::STATUS_AVAILABLE) {
                        $available += $commission;
                    }

                    if (null === $registeredAt || $values['registeredAt'] > $registeredAt) {
                        $registeredAt = clone $values['registeredAt'];
                    }

                    if ($level === 1) {
                        $direct += $values['commission'];
                    } else {
                        $indirect += $values['commission'];
                    }
                }
            }
        }

        return [$commission, $available, $indirect, $direct, $registeredAt];
    }

    public function createUserReferral(User $user, $month, $year, $level = 7)
    {
        $from = new \DateTime("$year-$month-01");
        $to = new \DateTime($from->format('Y-m-t'));

        list($commission, $available, $indirect, $direct, $registeredAt) = $this->calculateUserReferral($user, $from, $to, $level);

        $em = $this->getEntityManager();

        $referral = $this->findOneBy(['user' => $user, 'month' => "$year$month"]) ?: new Referral();

        $payment = $referral->getProcessing() + $referral->getPaid();

        $referral->setConcept('Referral Total')
            ->setUser($user)
            ->setMonth("$year$month")
            ->setAmount($commission)
            ->setAvailable($available - $payment)
            ->setPending($commission - $available - $payment)
            ->setIndirect($indirect)
            ->setDirect($direct)
            ->setRegisteredAt($registeredAt)
        ;

        $em->persist($referral);
        $em->flush();

        return $referral;
    }
}
