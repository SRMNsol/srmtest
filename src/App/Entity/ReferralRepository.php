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
            ->andWhere('r.status <> :invalid')
            ->groupBy('r.user')
            ->setParameter('user', $user)
            ->setParameter('invalid', Referral::STATUS_INVALID)
        ;

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function calculateUserReferral(User $user, \DateTime $from = null, \DateTime $to = null, $level = 7)
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
                    // not calculating cashback from extrabux or cashback without transaction
                    if ($cashback->getIsExtrabux() || null === $cashback->getTransaction()) {
                        continue;
                    }

                    $transaction = $cashback->getTransaction();
                    $share = $transaction->getCommissionByLevel($level);

                    $commission += $share;
                    $available += ($cashback->getStatus() === Cashback::STATUS_AVAILABLE) ? $share : 0;
                    $direct += ($level === 1) ? $share : 0;
                    $indirect += ($level > 1) ? $share : 0;

                    $registeredAt = (null === $registeredAt || $transaction->getRegisteredAt() > $registeredAt)
                        ? clone $transaction->getRegisteredAt()
                        : $registeredAt;
                }
            }
        }

        return [
            'commission' => $commission,
            'available' => $available,
            'indirect' => $indirect,
            'direct' => $direct,
            'registeredAt' => $registeredAt,
        ];
    }

    public function createUserReferral(User $user, $month, $year, $level = 7)
    {
        $from = new \DateTime("$year-$month-01");
        $to = new \DateTime($from->format('Y-m-t'));

        $values = $this->calculateUserReferral($user, $from, $to, $level);

        $em = $this->getEntityManager();

        $referral = $this->findOneBy([
            'user' => $user,
            'month' => "$year$month",
            'isExtrabux' => false,
        ]) ?: new Referral();

        $payment = $referral->getProcessing() + $referral->getPaid();

        $referral->setConcept('Referral Total')
            ->setUser($user)
            ->setMonth("$year$month")
            ->setAmount($values['commission'])
            ->setAvailable($values['available'] - $payment)
            ->setPending($values['commission'] - $values['available'] - $payment)
            ->setIndirect($values['indirect'])
            ->setDirect($values['direct'])
            ->setRegisteredAt($values['registeredAt'] ?: clone $from) // use first day of month when registeredAt is null
        ;

        $em->persist($referral);
        $em->flush();

        return $referral;
    }
}
