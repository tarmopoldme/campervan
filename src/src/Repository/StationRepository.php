<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Repository for Station Entity
 */
class StationRepository extends EntityRepository
{

    public function getRandomStations(int $limit, array $excludeStationIds = []): array
    {
        $queryBuilder = $this->createQueryBuilder('s');

        if ($excludeStationIds) {
            $queryBuilder
                ->where($queryBuilder->expr()->notIn('s.id', $excludeStationIds))
            ;
        }
        return $queryBuilder
            ->orderBy('RAND()')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
    }
}
