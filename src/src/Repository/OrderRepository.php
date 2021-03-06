<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Repository for Order Entity
 */
class OrderRepository extends EntityRepository
{

    /**
     * @throws NonUniqueResultException
     */
    public function getCampervanPreviousOrder(int $campervanId): ?Order
    {
        return $this
            ->createQueryBuilder('o')
            ->where('o.campervan=:campervanId')
            ->setParameter('campervanId', $campervanId)
            ->orderBy('o.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
