<?php
namespace App\Classes;

use App\Entity\Order;
use App\Entity\OrderEquipment;
use App\Entity\StationEquipmentDemand;
use App\Repository\StationEquipmentDemandRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EquipmentDemandDetector
 */
class EquipmentDemandDetector
{
    private Order $order;

    private EntityManagerInterface $em;

    public function __construct(Order $order, EntityManagerInterface $em)
    {
        $this->order = $order;
        $this->em = $em;
    }

    public function detect(): void
    {
        $this->updateDepartureDemands();
        $this->updateArrivalDemands();
    }

    private function updateDepartureDemands(): void
    {
        /** @var OrderEquipment $equipment */
        foreach ($this->order->getOrderEquipments() as $equipment) {
            /** @var StationEquipmentDemandRepository $repository */
            $repository = $this->em->getRepository(StationEquipmentDemand::class);

            $demand = $repository
                ->findOneByOrCreate([
                    'station' => $this->order->getStartStation()->getId(),
                    'equipment' => $equipment->getEquipment()->getId(),
                    'date' => $this->order->getStartDate()
                ])
            ;
            $this->saveDemand($demand, $equipment->getBookedCount());
        }
    }

    private function updateArrivalDemands(): void
    {
        /** @var OrderEquipment $equipment */
        foreach ($this->order->getOrderEquipments() as $equipment) {
            /** @var StationEquipmentDemandRepository $repository */
            $repository = $this->em->getRepository(StationEquipmentDemand::class);

            $demand = $repository
                ->findOneByOrCreate([
                    'station' => $this->order->getEndStation()->getId(),
                    'equipment' => $equipment->getEquipment()->getId(),
                    'date' => $this->order->getStartDate()
                ])
            ;
            $this->saveDemand($demand, $equipment->getBookedCount(), false);
        }
    }

    private function saveDemand(StationEquipmentDemand $demand, int $bookedCount, bool $departure = true): void
    {
        if ($departure) {
            $newBookedCount = $demand->getBookedCount() + $bookedCount;
            $newAvailableCount = $demand->getAvailableCount() - $bookedCount;
        } else {
            $newAvailableCount = $demand->getAvailableCount() + $bookedCount;
            $newBookedCount = $demand->getBookedCount() ?: 0;
        }

        $demand->setBookedCount($newBookedCount);
        $demand->setAvailableCount($newAvailableCount);

        $this->em->persist($demand);
        $this->em->flush();
    }
}
