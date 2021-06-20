<?php
namespace App\Classes;

use Doctrine\Persistence\ObjectRepository;

/**
 * Class EquipmentDemandDetector
 */
class EquipmentDemandSearcher
{

    private ObjectRepository $repository;

    public function __construct(ObjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search(array $filter = null): array
    {
        return $this->repository
            ->findByFilterAndJoinEquipment($filter)
        ;
    }

    private function getSearchCriteria(array $filter)
    {

    }
}
