<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvStationEquipment
 *
 * @ORM\Table(name="cv_station_equipment", indexes={@ORM\Index(name="equipment_id", columns={"equipment_id"}), @ORM\Index(name="station_id", columns={"station_id"})})
 * @ORM\Entity
 */
class StationEquipment
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="booked_count", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $bookedCount;

    /**
     * @var int
     *
     * @ORM\Column(name="available_count", type="integer", nullable=false, options={"comment"="Value might be negative"})
     */
    private $availableCount;

    /**
     * @var Station
     *
     * @ORM\ManyToOne(targetEntity="Station")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="station_id", referencedColumnName="id")
     * })
     */
    private $station;

    /**
     * @var Equipment
     *
     * @ORM\ManyToOne(targetEntity="Equipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     * })
     */
    private $equipment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getBookedCount(): ?int
    {
        return $this->bookedCount;
    }

    public function setBookedCount(int $bookedCount): self
    {
        $this->bookedCount = $bookedCount;

        return $this;
    }

    public function getAvailableCount(): ?int
    {
        return $this->availableCount;
    }

    public function setAvailableCount(int $availableCount): self
    {
        $this->availableCount = $availableCount;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }


}
