<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ManyToOne(targetEntity: Widget::class, inversedBy: 'actions')]
    #[JoinColumn(name: 'widget_id', referencedColumnName: 'id', nullable: true)]
    private Widget|null $widget = null;

    #[ManyToOne(targetEntity: Port::class)]
    #[JoinColumn(name: 'port_id', referencedColumnName: 'id', nullable: true)]
    private Port|null $port = null;

    #[ManyToOne(targetEntity: Actor::class, cascade: ["all"])]
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
     * @param int|null $id
     * @return Action
     */
    public function setId(?int $id): Action
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Widget|null
     */
    public function getWidget(): ?Widget
    {
        return $this->widget;
    }

    /**
     * @param Widget|null $widget
     * @return Action
     */
    public function setWidget(?Widget $widget): Action
    {
        $this->widget = $widget;
        return $this;
    }

    /**
     * @return Port|null
     */
    public function getPort(): ?Port
    {
        return $this->port;
    }

    /**
     * @param Port|null $port
     * @return Action
     */
    public function setPort(?Port $port): Action
    {
        $this->port = $port;
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
     * @return Action
     */
    public function setActor(?Actor $actor): Action
    {
        $this->actor = $actor;
        return $this;
    }
}
