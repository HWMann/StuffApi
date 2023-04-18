<?php

namespace App\Entity;

use App\Repository\ScreenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: ScreenRepository::class)]
class Screen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[OneToMany(targetEntity: Widget::class, mappedBy: 'screen')]
    private Collection $widgets;

    #[ORM\Column(nullable: false)]
    private bool $visible = true;

    public function __construct()
    {
        $this->widgets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Screen
     */
    public function setId(int $id): Screen
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
     * @return Collection|null
     */
    public function getWidgets(): ?Collection
    {
        return $this->widgets;
    }

    /**
     * @param Collection|null $widgets
     * @return Screen
     */
    public function setWidgets(?Collection $widgets): Screen
    {
        $this->widgets = $widgets;
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
     * @return Screen
     */
    public function setVisible(bool $visible): Screen
    {
        $this->visible = $visible;
        return $this;
    }


}
