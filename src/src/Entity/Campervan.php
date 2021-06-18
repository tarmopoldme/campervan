<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campervan
 *
 * @ORM\Table(name="cv_campervan")
 * @ORM\Entity
 */
class Campervan
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }


}
