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

    public function calculateUserReferral(User $user, $month, $year, $level = 7)
    {
        $em = $this->getEntityManager();
        $cashbackRepository = $em->getRepository('App\Entity\Cashback');

        $commission = 0.00;
        $payment = 0.00;
        $adjustment = 0.00;
        $registeredAt = null;
        $direct = 0.00;
        $indirect = 0.00;

        $tree = $user->getReferralTree($level);
        foreach ($tree as $level => $children) {
            foreach ($children as $child) {
                $cashbacks = $cashbackRepository->findCashbackForUser($child, $month, $year);

                foreach ($cashbacks as $cashback) {
                    $values = $cashback->calculateTransactionValues($level);

                    $commission += $values['commission'];
                    $payment += $values['payment'];
                    $adjustment += $values['adjustment'];
                    if (null === $registeredAt || $values['registeredAt'] > $registeredAt) {
                        $registeredAt = clone $values['registeredAt'];
                    }

                    if ($level === 1) {
                        $direct += $values['commission'] - $values['adjustment'];
                    } else {
                        $indirect += $values['commission'] - $values['adjustment'];
                    }
                }
            }
        }

        $referral = $this->findOneBy(['user' => $user, 'month' => "$year$month"]) ?: new Referral();

        $referral->setConcept('Referral Total')
            ->setUser($user)
            ->setMonth("$year$month")
            ->setAmount($commission - $adjustment)
            ->setAvailable($payment - $referral->getProcessing() - $referral->getPaid())
            ->setPending($referral->getAmount() - $referral->getAvailable())
            ->setIndirect($indirect)
            ->setDirect($direct)
            ->setRegisteredAt($registeredAt)
        ;

        $em->persist($referral);
        $em->flush();

        return $referral;
    }
}
