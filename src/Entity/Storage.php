<?php

namespace App\Entity;

use App\Repository\DarterRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: DarterRepository::class)]
class Storage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ManyToOne(targetEntity: "Thing", cascade: ["all"], fetch: "EAGER")]
    private Thing $thing;

    #[ManyToOne(targetEntity: "Box", cascade: ["all"], fetch: "EAGER")]
    private Box $box;

    #[ORM\Column(type: "integer")]
    private ?int $qty = 0;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Storage
     */
    public function setId(?int $id): Storage
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Thing
     */
    public function getThing(): Thing
    {
        return $this->thing;
    }

    /**
     * @param Thing $thing
     * @return Storage
     */
    public function setThing(Thing $thing): Storage
    {
        $this->thing = $thing;
        return $this;
    }

    /**
     * @return Box
     */
    public function getBox(): Box
    {
        return $this->box;
    }

    /**
     * @param Box $box
     * @return Storage
     */
    public function setBox(Box $box): Storage
    {
        $this->box = $box;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQty(): ?int
    {
        return $this->qty;
    }

    /**
     * @param int|null $qty
     * @return Storage
     */
    public function setQty(?int $qty): Storage
    {
        $this->qty = $qty;
        return $this;
    }


}