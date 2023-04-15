<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActorRepository::class)]
class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $topic = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $payload = null;

    public function __construct($data=null)
    {
        if($data!==null) $this->fromArray($data);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Box
     */
    public function setId(?int $id): Box
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
     * @return Box
     */
    public function setName(?string $name): Box
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTopic(): ?string
    {
        return $this->topic;
    }

    /**
     * @param string|null $topic
     * @return Actor
     */
    public function setTopic(?string $topic): Actor
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPayload(): ?string
    {
        return $this->payload;
    }

    /**
     * @param string|null $payload
     * @return Actor
     */
    public function setPayload(?string $payload): Actor
    {
        $this->payload = $payload;
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
            "topic" => $this->topic,
            "payload" => $this->payload
        ];
    }

    /**
     * @param array $data
     * @return Actor
     */
    public function fromArray(array $data): Actor
    {
        $this->id=$data["id"];
        $this->name=$data["name"];
        $this->topic=$data["topic"];
        $this->payload=$data["payload"];
        return $this;
    }
}
