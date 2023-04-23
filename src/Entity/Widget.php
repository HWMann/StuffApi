<?php

namespace App\Entity;

use App\Repository\WidgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity(repositoryClass: WidgetRepository::class)]
class Widget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ManyToOne(targetEntity: Screen::class, inversedBy: 'widgets')]
    #[JoinColumn(name: 'screen_id', referencedColumnName: 'id', nullable: true)]
    private Screen|null $screen = null;

    #[OneToMany(targetEntity: Action::class, mappedBy: 'widget', cascade: ["all"])]
    private Collection $actions;

    #[ORM\Column(nullable: false)]
    private bool $visible = true;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $type = null;

    #[ManyToOne(targetEntity: Actor::class,cascade: ["all"])]
    #[JoinColumn(name: 'status_actor_id', referencedColumnName: 'id', nullable: true)]
    private Actor|null $statusFrom = null;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
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
     * @return Widget
     */
    public function setId(?int $id): Widget
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
     * @return Widget
     */
    public function setName(?string $name): Widget
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Screen|null
     */
    public function getScreen(): ?Screen
    {
        return $this->screen;
    }

    /**
     * @param Screen|null $screen
     * @return Widget
     */
    public function setScreen(?Screen $screen): Widget
    {
        $this->screen = $screen;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    /**
     * @param Collection $actions
     * @return Widget
     */
    public function setActions(Collection $actions): Widget
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     * @return Widget
     */
    public function setVisible(bool $visible): Widget
    {
        $this->visible = $visible;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Widget
     */
    public function setType(?string $type): Widget
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Actor|null
     */
    public function getStatusFrom(): ?Actor
    {
        return $this->statusFrom;
    }

    /**
     * @param Actor|null $statusFrom
     * @return Widget
     */
    public function setStatusFrom(?Actor $statusFrom): Widget
    {
        $this->statusFrom = $statusFrom;
        return $this;
    }



}
