<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class StationRepository extends EntityRepository
{

    public function getRandomStations(int $limit = 2)
    {
        return $this
            ->createQueryBuilder('s')
            ->orderBy('RAND()')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
    }
}
