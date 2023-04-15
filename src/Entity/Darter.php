<?php

namespace App\Entity;

use App\Repository\DarterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DarterRepository::class)]
class Darter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 3)]
    private ?string $short = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $color1 = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $color2 = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $color3 = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Darter
     */
    public function setId(?int $id): Darter
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return Darter
     */
    public function setFirstName(?string $firstName): Darter
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return Darter
     */
    public function setLastName(?string $lastName): Darter
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShort(): ?string
    {
        return $this->short;
    }

    /**
     * @param string|null $short
     * @return Darter
     */
    public function setShort(?string $short): Darter
    {
        $this->short = $short;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor1(): ?string
    {
        return $this->color1;
    }

    /**
     * @param string|null $color1
     * @return Darter
     */
    public function setColor1(?string $color1): Darter
    {
        $this->color1 = $color1;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor2(): ?string
    {
        return $this->color2;
    }

    /**
     * @param string|null $color2
     * @return Darter
     */
    public function setColor2(?string $color2): Darter
    {
        $this->color2 = $color2;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor3(): ?string
    {
        return $this->color3;
    }

    /**
     * @param string|null $color3
     * @return Darter
     */
    public function setColor3(?string $color3): Darter
    {
        $this->color3 = $color3;

        return $this;
    }


}
