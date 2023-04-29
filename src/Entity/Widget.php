<?php

namespace App\Entity;

use App\Repository\WidgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\VirtualProperty;

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

    #[ORM\Column(nullable: false)]
    private bool $visible = true;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $type = null;

    #[ManyToOne(targetEntity: Actor::class, inversedBy: 'statusWidgets')]
    #[JoinColumn(name: 'status_actor_id', referencedColumnName: 'id', nullable: true)]
    #[SerializedName("statusActor")]
    private Actor|null $statusActor = null;

    #[OneToMany(targetEntity: Action::class, mappedBy: 'widget', cascade: ["all"])]
    private Collection $actions;

    #[ORM\Column(nullable: false)]
    private int $x = 0;

    #[ORM\Column(nullable: false)]
    private int $y = 0;

    #[ORM\Column(nullable: false)]
    private int $w = 1;

    #[ORM\Column(nullable: false)]
    private int $h = 1;


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
    public function getStatusActor(): ?Actor
    {
        return $this->statusActor;
    }

    /**
     * @param Actor|null $statusActor
     * @return Widget
     */
    public function setStatusActor(?Actor $statusActor): Widget
    {
        $this->statusActor = $statusActor;
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
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     * @return Widget
     */
    public function setX(int $x): Widget
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     * @return Widget
     */
    public function setY(int $y): Widget
    {
        $this->y = $y;
        return $this;
    }

    /**
     * @return int
     */
    public function getW(): int
    {
        return $this->w;
    }

    /**
     * @param int $w
     * @return Widget
     */
    public function setW(int $w): Widget
    {
        $this->w = $w;
        return $this;
    }

    /**
     * @return int
     */
    public function getH(): int
    {
        return $this->h;
    }

    /**
     * @param int $h
     * @return Widget
     */
    public function setH(int $h): Widget
    {
        $this->h = $h;
        return $this;
    }

    /**
     * @VirtualProperty
     * @Type("string")
     * @SerializedName("cssGridCoords")
     */
    public function cssGridCoords()
    {
        return sprintf("grid-column: %d / span %d;grid-row: %d / span %d",
            $this->x+1,
            $this->w,
            $this->y+1,
            $this->h,
        );
    }


}
