<?php

namespace App\Repository;

use App\Entity\Equipment;
use App\Entity\Station;
use App\Entity\StationEquipmentDemand;
use Doctrine\ORM\EntityRepository;

/**
 * Repository for StationEquipmentDemand Entity
 */
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
}
