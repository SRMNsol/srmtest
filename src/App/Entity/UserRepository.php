<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function getTotalShoppers(\DateTime $start, \DateTime $end)
    {
        $before = clone $end;
        $before->add(\DateInterval::createFromDateString('+1 day'));

        $qb = $this->createQueryBuilder('u');
        $qb->select('COUNT(DISTINCT u)');
        $qb->join('u.payables', 'p', 'WITH',
            $qb->expr()->andx(
                'p INSTANCE OF App\Entity\Cashback',
                'p.status <> :invalid'
            )
        )->setParameter('invalid', Payable::STATUS_INVALID);
        $qb->where('p.registeredAt >= :after')->setParameter('after', $start);
        $qb->andWhere('p.registeredAt < :before')->setParameter('before', $before);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getTotalNewUsers(\DateTime $start, \DateTime $end)
    {
        $before = clone $end;
        $before->add(\DateInterval::createFromDateString('+1 day'));

        $qb = $this->createQueryBuilder('u');
        $qb->select('COUNT(u)');
        $qb->where('u.createdAt >= :after')->setParameter('after', $start);
        $qb->andWhere('u.createdAt < :before')->setParameter('before', $before);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getTotalReferrers(\DateTime $start, \DateTime $end)
    {
        $before = clone $end;
        $before->add(\DateInterval::createFromDateString('+1 day'));

        $qb = $this->createQueryBuilder('u');
        $qb->select('COUNT(DISTINCT u)');
        $qb->join('u.referredUsers', 'r', 'WITH', $qb->expr()->andx('r.createdAt >= :after', 'r.createdAt < :before'));
        $qb->setParameter('after', $start);
        $qb->setParameter('before', $before);

        return $qb->getQuery()->getSingleScalarResult();
    }



    public function getTotalReferrersList(\DateTime $start, \DateTime $end)
    {
        $before = clone $end;
        $before->add(\DateInterval::createFromDateString('+1 day'));

        $qb = $this->createQueryBuilder('u');
        $qb->select('DISTINCT u');
        $qb->join('u.referredUsers', 'r', 'WITH', $qb->expr()->andx('r.createdAt >= :after', 'r.createdAt < :before'));
        $qb->setParameter('after', $start);
        $qb->setParameter('before', $before);

        return $qb->getQuery()->getScalarResult();
    }
    public function getCommissionStats(\DateTime $start, \DateTime $end, array $users = null, $type = 'commission', $sum = 'amount')
    {
        $before = clone $end;
        $before->add(\DateInterval::createFromDateString('+1 day'));

        $qb = $this->createQueryBuilder('u');
        switch ($type) {
            case 'commission' :
                $qb->join('u.payables', 'p', 'WITH',
                    $qb->expr()->andx(
                        $qb->expr()->orx(
                            'p INSTANCE OF App\Entity\Cashback',
                            'p INSTANCE OF App\Entity\Referral'
                        ),
                        'p.status <> :invalid'
                    )
                )->setParameter(':invalid', Payable::STATUS_INVALID);
                break;
            case 'cashback' :
                $qb->join('u.payables', 'p', 'WITH',
                    $qb->expr()->andx(
                        'p INSTANCE OF App\Entity\Cashback',
                        'p.status <> :invalid'
                    )
                )->setParameter(':invalid', Payable::STATUS_INVALID);
                break;
            case 'referral' :
                $qb->join('u.payables', 'p', 'WITH',
                    $qb->expr()->andx(
                        'p INSTANCE OF App\Entity\Referral',
                        'p.status <> :invalid'
                    )
                )->setParameter(':invalid', Payable::STATUS_INVALID);
                break;
            default :
                throw new \Exception('Invalid type');
        }

        if (!in_array($sum, ['amount', 'paid'])) {
            throw new \Exception(sprintf('Invalid field %', $sum));
        }

        $qb->addSelect("SUM(p.{$sum}) AS total");
        $qb->where('p.registeredAt >= :after')->setParameter('after', $start);
        $qb->andWhere('p.registeredAt < :before')->setParameter('before', $before);
        $qb->groupBy('u');
        $qb->having('total > 0');
        if (count($users) > 0) {
            // return users in parameter
            $qb->andWhere('u IN (:users)')->setParameter('users', $users);
        }
        $qb->orderBy('u.id'); // order by id to merge results easily

        return $qb->getQuery()->getResult();
    }

    public function getPersonalCashbackStats(\DateTime $start, \DateTime $end, array $users = null)
    {
        return $this->getCommissionStats($start, $end, $users, 'cashback');
    }

    public function getReferralCashbackStats(\DateTime $start, \DateTime $end, array $users = null)
    {
        return $this->getCommissionStats($start, $end, $users, 'referral');
    }

    public function getCommissionPaidStats(\DateTime $start, \DateTime $end, array $users = null)
    {
        return $this->getCommissionStats($start, $end, $users, 'commission', 'paid');
    }

    public function getReferralPaidStats(\DateTime $start, \DateTime $end, array $users = null)
    {
        return $this->getCommissionStats($start, $end, $users, 'referral', 'paid');
    }

    public function getTransactionStats(\DateTime $start, \DateTime $end, array $users = null)
    {
        $before = clone $end;
        $before->add(\DateInterval::createFromDateString('+1 day'));

        // this query uses Cashback as root entity
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')->from('App\Entity\Cashback', 'c');
        $qb->join('c.user', 'u', 'WITH', 'c.status <> :invalid');
        $qb->setParameter('invalid', Cashback::STATUS_INVALID);
        $qb->join('c.transaction', 't', 'WITH', 't.status <> :canceled');
        $qb->setParameter('canceled', Transaction::STATUS_CANCELED);

        $qb->addSelect('u');
        $qb->addSelect('SUM(t.total) AS total');
        $qb->where('c.registeredAt >= :after')->setParameter('after', $start);
        $qb->andWhere('c.registeredAt < :before')->setParameter('before', $before);
        $qb->groupBy('c');
        $qb->groupBy('t');
        $qb->having('total > 0');
        if (count($users) > 0) {
            // return users in parameter
            $qb->andWhere('u IN (?3)')->setParameter(3, $users);
        }
        $qb->orderBy('u.id'); // order by id to merge results easily

        $rows = $qb->getQuery()->getResult();

        // build result as if user were the root entity
        $result = [];

        // rows is ordered by user id
        $i = 0;
        foreach ($rows as $row) {
            $user = $row[0]->getUser();
            // first pass, or current result not for the same user, increment i
            if ($i === 0 || $result[$i][0] !== $user) {
                $i++;
            }
            // initialize new result
            if (!isset($result[$i])) {
                $result[$i] = [0 => $user, 'total' => 0.00];
            }
            // sum total
            $result[$i]['total'] += $row['total'];
        }

        return $result;
    }

    public function getNetworkStats(\DateTime $start, \DateTime $end, array $users = null)
    {
        $before = clone $end;
        $before->add(\DateInterval::createFromDateString('+1 day'));

        $qb = $this->createQueryBuilder('level0');
        $qb->leftJoin('level0.referredUsers', 'level1', 'WITH', $qb->expr()->andx('level1.createdAt >= :after', 'level1.createdAt < :before'));
        $qb->leftJoin('level1.referredUsers', 'level2', 'WITH', $qb->expr()->andx('level2.createdAt >= :after', 'level2.createdAt < :before'));
        $qb->leftJoin('level2.referredUsers', 'level3', 'WITH', $qb->expr()->andx('level3.createdAt >= :after', 'level3.createdAt < :before'));
        $qb->leftJoin('level3.referredUsers', 'level4', 'WITH', $qb->expr()->andx('level4.createdAt >= :after', 'level4.createdAt < :before'));
        $qb->leftJoin('level4.referredUsers', 'level5', 'WITH', $qb->expr()->andx('level5.createdAt >= :after', 'level5.createdAt < :before'));
        $qb->leftJoin('level5.referredUsers', 'level6', 'WITH', $qb->expr()->andx('level6.createdAt >= :after', 'level6.createdAt < :before'));
        $qb->leftJoin('level6.referredUsers', 'level7', 'WITH', $qb->expr()->andx('level7.createdAt >= :after', 'level7.createdAt < :before'));
        $qb->addSelect('COUNT(level1) + COUNT(level2) + COUNT(level3) + COUNT(level4) + COUNT(level5) + COUNT(level6) + COUNT(level7) AS total');
        $qb->setParameter('after', $start);
        $qb->setParameter('before', $before);
        $qb->groupBy('level0');
        $qb->having('total > 0');
        if (count($users) > 0) {
            // return users in parameter
            $qb->andWhere('level0 IN (:users)')->setParameter('users', $users);
        }
        $qb->orderBy('level0.id'); // order by id to merge results easily

        return $qb->getQuery()->getResult();
    }

    public function getDirectNetworkStats(\DateTime $start, \DateTime $end, array $users = null)
    {
        $before = clone $end;
        $before->add(\DateInterval::createFromDateString('+1 day'));

        $qb = $this->createQueryBuilder('level0');
        $qb->join('level0.referredUsers', 'level1', 'WITH', $qb->expr()->andx('level1.createdAt >= :after', 'level1.createdAt < :before'));
        $qb->addSelect('COUNT(level1) AS total');
        $qb->setParameter('after', $start);
        $qb->setParameter('before', $before);
        $qb->groupBy('level0');
        $qb->having('total > 0');
        if (count($users) > 0) {
            // return users in parameter
            $qb->andWhere('level0 IN (:users)')->setParameter('users', $users);
        }
        $qb->orderBy('level0.id'); // order by id to merge results easily

        return $qb->getQuery()->getResult();
    }

    public function getTopUsers(\DateTime $start, \DateTime $end, $main = 'commission', $dir = 'desc')
    {
        $methods = [
            'commission'  => 'getCommissionStats',
            'cashback'    => 'getPersonalCashbackStats',
            'referral'    => 'getReferralCashbackStats',
            'transaction' => 'getTransactionStats',
            'network'     => 'getNetworkStats',
            'direct'      => 'getDirectNetworkStats',
            'payment'     => 'getCommissionPaidStats',
            'taxable'     => 'getReferralPaidStats',
        ];

        if (!array_key_exists($main, $methods)) {
            throw new \Exception(sprintf('Invalid stats type %s', $main));
        }

        if (!in_array($dir, ['asc', 'desc'])) {
            throw new \Exception(sprintf('Invalid sort %s', $dir));
        }

        $stats[$main] = call_user_func_array([$this, $methods[$main]], [$start, $end]);

        $users = array_map(function ($result) {
            return $result[0];
        }, $stats[$main]);

        foreach ($methods as $key => $method) {
            if ($key === $main) {
                continue;
            }
            $stats[$key] = call_user_func_array([$this, $method], [$start, $end, $users]);
        }

        // array must be ordered by user id
        $finder = function (&$arr, $user, $default) {
            $row = current($arr);
            while (false !== $row && $row[0]->getId() < $user->getId()) {
                $row = next($arr);
            }
            if ($row[0] === $user) {
                return $row['total'];
            }
            return $default;
        };

        $topUsers = [];
        foreach ($stats[$main] as $data) {
            $user = $data[0];

            $row = [
                0 => $user,
                "$main" => $data['total'],
            ];

            foreach($stats as $key => $result) {
                if ($key === $main) {
                    continue;
                }
                $row[$key] = $finder($result, $user, 0);
            }

            $topUsers[] = $row;
        }

        usort($topUsers, function ($row1, $row2) use ($main, $dir) {
            $value1 = floor($row1[$main] * 100);
            $value2 = floor($row2[$main] * 100);

            // same value, compare by id
            if ($value1 === $value2) {
                $value1 = $row1[0]->getId();
                $value2 = $row2[0]->getId();
            }

            $res = ($value1 < $value2) ? -1 : 1;
            if ($dir === 'desc') {
                $res *= -1; // reverse order
            }

            return $res;
        });

        return $topUsers;
    }
}
