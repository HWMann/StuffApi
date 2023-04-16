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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statusTopic = null;

    #[ORM\Column(nullable: false)]
    private int|null $status = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $jsonPath = null;

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
     * @return Actor
     */
    public function setId(?int $id): Actor
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
     * @return Actor
     */
    public function setName(?string $name): Actor
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
     * @return string|null
     */
    public function getStatusTopic(): ?string
    {
        return $this->statusTopic;
    }

    /**
     * @param string|null $statusTopic
     * @return Actor
     */
    public function setStatusTopic(?string $statusTopic): Actor
    {
        $this->statusTopic = $statusTopic;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Actor
     */
    public function setStatus(int $status): Actor
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJsonPath(): ?string
    {
        return $this->jsonPath;
    }

    /**
     * @param string|null $jsonPath
     * @return Actor

     */
    public function setJsonPath(?string $jsonPath): Actor
    {
        if($jsonPath=="") $this->jsonPath=null; else $this->jsonPath = $jsonPath;
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
            "payload" => $this->payload,
            "statusTopic" => $this->statusTopic,
            "status" => $this->status,
            "jsonPath" => $this->jsonPath
        ];
    }

    /**
     * @param array $data
     * @return Actor
     */
    public function fromArray(array $data): Actor
    {
        $this->id=$data["id"];
        $this->name=$data["name"] ?? null;
        $this->topic=$data["topic"] ?? null;
        $this->payload=$data["payload"] ?? null;
        $this->statusTopic=$data["statusTopic"] ?? null;
        $this->jsonPath=($data["jsonPath"]!="") ? $data["jsonPath"] : null;
        return $this;
    }
}
