<?php

namespace App\Entity;

use App\Repository\SensorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SensorRepository::class)]
class Sensor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $topic = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $sensorType = null;


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
     * @return Sensor
     */
    public function setId(?int $id): Sensor
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
     * @return Sensor
     */
    public function setName(?string $name): Sensor
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
     * @return Sensor
     */
    public function setTopic(?string $topic): Sensor
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSensorType(): ?string
    {
        return $this->sensorType;
    }

    /**
     * @param string|null $sensorType
     * @return Sensor
     */
    public function setSensorType(?string $sensorType): Sensor
    {
        $this->sensorType = $sensorType;
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
            "sensorType" => $this->sensorType
        ];
    }

    /**
     * @param array $data
     * @return Actor
     */
    public function fromArray(array $data): Sensor
    {
        $this->id=$data["id"];
        $this->name=$data["name"] ?? null;
        $this->topic=$data["topic"] ?? null;
        $this->sensorType=$data["sensorType"] ?? null;
        return $this;
    }
}
