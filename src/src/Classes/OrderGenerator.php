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
        $dates = $this->getStartAndEndDate();
        // grab two random stations for start and end stations
        $stations = $this->em->getRepository(Station::class)
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
        $this->em->persist($order);
        $this->em->flush();
    }

    private function getStartAndEndDate(): array
    {
        $randomStart = random_int(1, 30);
        $randomEnd = random_int(1, 7);

        $start = (new DateTime())->modify("+$randomStart day");
        $end = (clone $start)->modify("+$randomEnd day");

        return [
            'start_date' => $start,
            'end_date' => $end
        ];
    }

//    private function getRandomEquipment()
//    {
//
//    }
}