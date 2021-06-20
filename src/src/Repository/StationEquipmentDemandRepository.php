<?php

namespace App\Repository;

use App\Entity\Equipment;
use App\Entity\Station;
use App\Entity\StationEquipmentDemand;
use Doctrine\ORM\EntityRepository;

class StationEquipmentDemandRepository extends EntityRepository
{

    public function findOneByOrCreate(array $criteria): StationEquipmentDemand
    {
        $demand = $this->findOneBy($criteria);
        if ($demand === null) {
            $demand = new StationEquipmentDemand();
            $demand->setStation($this->_em->getReference(Station::class, $criteria['station']));
            $demand->setEquipment($this->_em->getReference(Equipment::class, $criteria['equipment']));
            $demand->setDate($criteria['date']);
        }
        return $demand;
    }

    public function findByFilterAndJoinEquipment(array $filter = null): array
    {
        $queryBuilder = $this
            ->createQueryBuilder('ed')
            ->innerJoin('ed.equipment', 'e')
            ->orderBy('ed.date', 'ASC')
        ;
        if (!empty($filter['stationId'])) {
            $queryBuilder
                ->where('ed.station=:stationId')
                ->setParameter('stationId', $filter['stationId'])
            ;
        }

        if (!empty($filter['dateFrom'])) {
            $queryBuilder
                ->andWhere('ed.date >= :dateFrom')
                ->setParameter('dateFrom', $filter['dateFrom'])
            ;
        }

        if (!empty($filter['dateUntil'])) {
            $queryBuilder
                ->andWhere('ed.date <= :dateUntil')
                ->setParameter('dateUntil', $filter['dateUntil'])
            ;
        }

        return $queryBuilder->getQuery()->execute();

    }

}
