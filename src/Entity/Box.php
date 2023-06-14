<?php

namespace App\Entity;

use App\Repository\BoxRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoxRepository::class)]
class Box
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $short = null;

    #[ORM\OneToMany(targetEntity: 'Box', mappedBy: 'parent')]
    private ?Collection $children = null;

    #[ORM\ManyToOne(targetEntity: 'Box', inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent', referencedColumnName: 'id')]
    #[Excl]
    private ?Box $parent = null;

    #[ORM\Column(type: "boolean")]
    private bool $trashed = false;

    public function __construct()
    {
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
    public function getShort(): ?string
    {
        return $this->short;
    }

    /**
     * @param string|null $short
     * @return Box
     */
    public function setShort(?string $short): Box
    {
        $this->short = $short;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getChildren(): ?Collection
    {
        return $this->children;
    }

    /**
     * @param Collection|null $children
     * @return Box
     */
    public function setChildren(?Collection $children): Box
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return Box|null
     */
    public function getParent(): ?Box
    {
        return $this->parent;
    }

    /**
     * @param Box|null $parent
     * @return Box
     */
    public function setParent(?Box $parent): Box
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTrashed(): bool
    {
        return $this->trashed;
    }

    /**
     * @param bool $trashed
     * @return Box
     */
    public function setTrashed(bool $trashed): Box
    {
        $this->trashed = $trashed;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray():array {
        if($this->parent===null) {
            $parent=["id" => 0,"name" => "none selected", "path" => "."];
        } else {
            $parent=["id" => $this->parent->getId(),"name" => $this->parent->getName(), "path" => "."];
        }

        return [
            "id" => $this->id,
            "name" => $this->name,
            "short" => $this->short,
            "parent" => $parent
        ];
    }

}
