<?php

namespace App\Entity;

use App\Repository\PortRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: PortRepository::class)]
class Port
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $payload = null;

    #[ManyToOne(targetEntity: Actor::class,cascade: ["all"], inversedBy: "ports")]
    #[JoinColumn(name: 'actor_id', referencedColumnName: 'id', nullable: true)]
    private Actor|null $actor = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Port
     */
    public function setId(?int $id): Port
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
     * @return Port
     */
    public function setName(?string $name): Port
    {
        $this->name = $name;
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
     * @return Port
     */
    public function setPayload(?string $payload): Port
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return Actor|null
     */
    public function getActor(): ?Actor
    {
        return $this->actor;
    }

    /**
     * @param Actor|null $actor
     * @return Port
     */
    public function setActor(?Actor $actor): Port
    {
        $this->actor = $actor;
        return $this;
    }



}
