<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class EquipmentRepository extends EntityRepository
{

    /**
     * @param int $limit
     * @return int|mixed|string
     */
    public function getRandomEquipment(int $limit = 5)
    {
        return $this
            ->createQueryBuilder('e')
            ->orderBy('RAND()')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
    }
}
