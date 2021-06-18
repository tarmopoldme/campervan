<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvOrderEquipment
 *
 * @ORM\Table(name="cv_order_equipment", indexes={@ORM\Index(name="equipment_id", columns={"equipment_id"}), @ORM\Index(name="order_id", columns={"order_id"})})
 * @ORM\Entity
 */
class OrderEquipment
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
     * @var int
     *
     * @ORM\Column(name="booked_count", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $bookedCount;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

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

    public function getBookedCount(): ?int
    {
        return $this->bookedCount;
    }

    public function setBookedCount(int $bookedCount): self
    {
        $this->bookedCount = $bookedCount;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

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
