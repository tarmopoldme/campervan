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
 * Start and end station are randomly picked between all existing stations from database
 * Order start is random date between now + 30 days
 * Order end is random date between order start + 7 days
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

        (new EquipmentGenerator($order, $this->em))->generate();

        $this->em->persist($order);
        $this->em->flush();

        (new DemandDetector($order, $this->em))->detect();
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