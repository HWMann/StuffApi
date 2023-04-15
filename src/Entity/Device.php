<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statusTopic = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?DateTime $lastAliveMessage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip = null;

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
     * @return Device
     */
    public function setId(?int $id): Device
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
     * @return Device
     */
    public function setName(?string $name): Device
    {
        $this->name = $name;
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
     * @return Device
     */
    public function setStatusTopic(?string $statusTopic): Device
    {
        $this->statusTopic = $statusTopic;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getLastAliveMessage(): ?DateTime
    {
        return $this->lastAliveMessage;
    }

    /**
     * @param DateTime|null $lastAliveMessage
     * @return Device
     */
    public function setLastAliveMessage(?DateTime $lastAliveMessage): Device
    {
        $this->lastAliveMessage = $lastAliveMessage;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     * @return Device
     */
    public function setIp(?string $ip): Device
    {
        $this->ip = $ip;
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
            "statusTopic" => $this->statusTopic,
            "lastAliveMessage" => $this->lastAliveMessage,
            "ip" => $this->ip
        ];
    }

    /**
     * @param array $data
     * @return Device
     */
    public function fromArray(array $data): Device
    {
        $this->id=$data["id"];
        $this->name=$data["name"] ?? null;
        $this->statusTopic=$data["statusTopic"] ?? null;
        $this->lastAliveMessage=$data["lastAliveMessage"] ?? null;
        return $this;
    }
}
