<?php
namespace App\Classes\Order;

use App\Classes\Station\Equipment\DemandDetector;
use App\Entity\Campervan;
use App\Entity\Order;
use App\Entity\Station;
use App\Interfaces\CampervanGenerator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This random order generator generates order for given campervan
 *
 * If no previous order exists start/end stations are randomly picked from database
 * Order start is random date between now + 15 days
 * Order end is random date between order start + 5 days
 *
 * If previous order exists then new order starting station is previous order end station
 * And new order start date is next day after previous order end
 *
 */
class Generator implements CampervanGenerator
{
    private Campervan $campervan;

    private EntityManagerInterface $em;

    public function __construct(Campervan $campervan, EntityManagerInterface $em)
    {
        $this->campervan = $campervan;
        $this->em = $em;
    }

    public function generate(): void
    {
        /** @var Order $previousOrder */
        $previousOrder = $this->em
            ->getRepository(Order::class)
            ->getCampervanPreviousOrder($this->campervan->getId())
        ;
        if ($previousOrder) {
            $startStation = $previousOrder->getEndStation();
            [$endStation] = $this->em
                ->getRepository(Station::class)
                ->getRandomStations(1, [$startStation->getId()])
            ;
            [$startDate, $endDate] = $this->getRandomStartAndEndDate($previousOrder->getEndDate());
        } else {
            [$startDate, $endDate] = $this->getRandomStartAndEndDate();
            [$startStation, $endStation] = $this->em
                ->getRepository(Station::class)
                ->getRandomStations(2)
            ;
        }

        $order = new Order();
        $order
            ->setCampervan($this->campervan)
            ->setStartStation($startStation)
            ->setEndStation($endStation)
            ->setStartDate($startDate)
            ->setEndDate($endDate)
        ;

        (new EquipmentGenerator($order, $this->em))->generate();

        $this->em->persist($order);
        $this->em->flush();

        (new DemandDetector($order, $this->em))->detect();
    }

    private function getRandomStartAndEndDate(DateTime $previousOrderEndDate = null): array
    {
        if ($previousOrderEndDate) {
            $startDate = $previousOrderEndDate->modify('+1 day');
        } else {
            $randomStart = random_int(1, 15);
            $startDate = (new DateTime())->modify("+$randomStart day");
        }

        $randomEnd = random_int(1, 5);
        $endDate = (clone $startDate)->modify("+$randomEnd day");

        return [$startDate, $endDate];
    }
}