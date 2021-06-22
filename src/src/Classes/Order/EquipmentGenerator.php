<?php
namespace App\Classes\Order;

use App\Entity\Equipment;
use App\Entity\Order;
use App\Entity\OrderEquipment;
use App\Interfaces\CampervanGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * This object is responsible for generating random equipment for given order
 * Random means that random number of equipment of all possible equipments are taken for order
 *
 * Amount of equipment is also randomized between values 1 - 10
 */
class EquipmentGenerator implements CampervanGenerator
{
    private Order $order;

    private EntityManagerInterface $em;

    public function __construct(Order $order, EntityManagerInterface $em)
    {
        $this->order = $order;
        $this->em = $em;
    }

    /**
     * @throws Exception
     */
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