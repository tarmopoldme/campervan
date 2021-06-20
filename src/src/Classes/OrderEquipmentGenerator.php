<?php
namespace App\Classes;

use App\Entity\Equipment;
use App\Entity\Order;
use App\Entity\OrderEquipment;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderEquipmentGenerator
 */
class OrderEquipmentGenerator
{
    private Order $order;

    private EntityManagerInterface $em;

    public function __construct(Order $order, EntityManagerInterface $em)
    {
        $this->order = $order;
        $this->em = $em;
    }

    public function generate(): void
    {
        $equipments = $this->em
            ->getRepository(Equipment::class)
            ->getRandomEquipment(random_int(1, 5))
        ;
        $orderEquipments = new ArrayCollection();

        foreach ($equipments as $equipment) {
            $orderEquipment = new OrderEquipment();
            $orderEquipment->setOrder($this->order);
            $orderEquipment->setEquipment($equipment);
            $orderEquipment->setBookedCount(random_int(1, 10));
            $orderEquipments->add($orderEquipment);
        }
        $this->order->setOrderEquipments($orderEquipments);
    }
}