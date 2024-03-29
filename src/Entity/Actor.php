<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use JMS\Serializer\Annotation\SerializedName;

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
    #[SerializedName("statusTopic")]
    private ?string $statusTopic = null;

    #[ORM\Column(nullable: false)]
    private int|null $status = 0;

    #[ORM\Column(length: 255, nullable: true)]
    #[SerializedName("jsonPath")]
    private ?string $jsonPath = null;

    #[OneToMany(targetEntity: Widget::class, mappedBy: 'statusActor')]
    private Collection $statusWidgets;

    #[OneToMany(targetEntity: Port::class, mappedBy: 'actor')]
    #[SerializedName("statusWidget")]
    private Collection $ports;

    public function __construct()
    {
        $this->ports = new ArrayCollection();
        $this->statusWidgets = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getPorts(): ArrayCollection
    {
        return $this->ports;
    }

    /**
     * @param ArrayCollection $ports
     * @return Actor
     */
    public function setPorts(ArrayCollection $ports): Actor
    {
        $this->ports = $ports;
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
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     * @return Actor
     */
    public function setStatus(?int $status): Actor
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
        $this->jsonPath = $jsonPath;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getStatusWidgets(): Collection
    {
        return $this->statusWidgets;
    }

    /**
     * @param Collection $statusWidgets
     * @return Actor
     */
    public function setStatusWidgets(Collection $statusWidgets): Actor
    {
        $this->statusWidgets = $statusWidgets;
        return $this;
    }
}
