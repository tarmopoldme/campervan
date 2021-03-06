<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CvOrder
 *
 * @ORM\Table(name="cv_order", indexes={@ORM\Index(name="start_station_id", columns={"start_station_id"}), @ORM\Index(name="end_station_id", columns={"end_station_id"}), @ORM\Index(name="campervan_id", columns={"campervan_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     */
    private $endDate;

    /**
     * @var Campervan
     *
     * @ORM\ManyToOne(targetEntity="Campervan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="campervan_id", referencedColumnName="id")
     * })
     */
    private $campervan;

    /**
     * @var Station
     *
     * @ORM\ManyToOne(targetEntity="Station")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="start_station_id", referencedColumnName="id")
     * })
     */
    private $startStation;

    /**
     * @var Station
     *
     * @ORM\ManyToOne(targetEntity="Station")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="end_station_id", referencedColumnName="id")
     * })
     */
    private $endStation;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="OrderEquipment", mappedBy="order", cascade={"persist", "remove"})
     */
    private $orderEquipments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCampervan(): ?Campervan
    {
        return $this->campervan;
    }

    public function setCampervan(?Campervan $campervan): self
    {
        $this->campervan = $campervan;

        return $this;
    }

    public function getStartStation(): ?Station
    {
        return $this->startStation;
    }

    public function setStartStation(?Station $startStation): self
    {
        $this->startStation = $startStation;

        return $this;
    }

    public function getEndStation(): ?Station
    {
        return $this->endStation;
    }

    public function setEndStation(?Station $endStation): self
    {
        $this->endStation = $endStation;

        return $this;
    }

    public function getOrderEquipments(): ?Collection
    {
        return $this->orderEquipments;
    }

    public function setOrderEquipments(Collection $orderEquipments): self
    {
        /** @var OrderEquipment $orderEquipment */
        foreach ($orderEquipments as $orderEquipment) {
            $orderEquipment->setOrder($this);
        }
        $this->orderEquipments = $orderEquipments;

        return $this;
    }

}
