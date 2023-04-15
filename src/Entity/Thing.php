<?php

namespace App\Entity;

use App\Repository\ThingRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: ThingRepository::class)]
class Thing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[OneToMany(mappedBy: "thing", targetEntity: "Storage", cascade: ["persist", "remove", "merge"], orphanRemoval: true)]
    public iterable $storedIn;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: "array", nullable: true)]
    private ?array $tags = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
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
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return Thing
     */
    public function setImage(?string $image): Thing
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @param array|null $tags
     * @return Thing
     */
    public function setTags(?array $tags): Thing
    {
        $this->tags = $tags;
        return $this;
    }


    /**
     * @param array $data
     * @return Thing
     */
    public static function create(array $data):Thing {
        $thing=new self();
        $thing->fromArray($data);
        return $thing;
    }

    /**
     * @return iterable
     */
    public function getStoredIn(): iterable
    {
        return $this->storedIn;
    }

    /**
     * @param iterable $storedIn
     * @return Thing
     */
    public function setStoredIn(iterable $storedIn): Thing
    {
        $this->storedIn = $storedIn;
        return $this;
    }


    /**
     * @return array
     */
    public function toArray():array {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "tags" => $this->tags
        ];
    }

    /**
     * @param array $data
     * @return Thing
     */
    public function fromArray(array $data):Thing {
        if(isset($data["id"])) $this->id=(int)$data["id"];
        if(isset($data["name"])) $this->name=$data["name"];
        if(isset($data["tags"])) $this->tags=$data["tags"];
        return $this;
    }

}