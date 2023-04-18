<?php

namespace App\Entity;

use App\Repository\WidgetRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: WidgetRepository::class)]
class Widget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ManyToOne(targetEntity: Screen::class, inversedBy: 'widgets',cascade: ["persist"])]
    #[JoinColumn(name: 'screen_id', referencedColumnName: 'id', nullable: true)]
    private Screen|null $screen = null;

    #[JoinTable(name: 'widgets_actor')]
    #[JoinColumn(name: 'actor_id', referencedColumnName: 'id')]
    #[InverseJoinColumn(name: 'widget_id', referencedColumnName: 'id')]
    #[ManyToMany(targetEntity: Actor::class)]
    private Collection $actors;

    #[ORM\Column(nullable: false)]
    private bool $visible = true;

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
    public function getActors(): Collection
    {
        return $this->actors;
    }

    /**
     * @param Collection $actors
     * @return Widget
     */
    public function setActors(Collection $actors): Widget
    {
        $this->actors = $actors;
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


}
