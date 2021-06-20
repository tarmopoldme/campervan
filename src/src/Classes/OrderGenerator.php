<?php
namespace App\Classes;

use App\Entity\Campervan;
use App\Entity\Order;
use App\Entity\Station;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class OrderGenerator
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
        $dates = $this->getRandomStartAndEndDate();
        $stations = $this->em
            ->getRepository(Station::class)
            ->getRandomStations(2)
        ;

        $order = new Order();
        $order
            ->setCampervan($this->campervan)
            ->setStartStation($stations[0])
            ->setEndStation($stations[1])
            ->setStartDate($dates['start_date'])
            ->setEndDate($dates['end_date'])
        ;

        (new OrderEquipmentGenerator($order, $this->em))->generate();

        $this->em->persist($order);
        $this->em->flush();

        (new EquipmentDemandDetector($order, $this->em))->detect();
    }

    private function getRandomStartAndEndDate(): array
    {
        $randomStart = random_int(1, 30);
        $randomEnd = random_int(1, 7);

        $startDate = (new DateTime())->modify("+$randomStart day");
        $endDate = (clone $startDate)->modify("+$randomEnd day");

        return [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
    }
}