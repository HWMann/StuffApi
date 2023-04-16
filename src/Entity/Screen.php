<?php

namespace App\Entity;

use App\Repository\ScreenRepository;
use App\Repository\WidgetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScreenRepository::class)]
class Screen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Screen
     */
    public function setId(?int $id): Screen
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Screen
     */
    public function setName(?string $name): Screen
    {
        $this->name = $name;
        return $this;
    }



    /**
     * @return array
     */
    public function toArray():array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
        ];
    }

    /**
     * @param array $data
     * @return Screen
     */
    public function fromArray(array $data): Screen
    {
        $this->id=$data["id"];
        $this->name=$data["name"] ?? null;
        return $this;
    }
}
