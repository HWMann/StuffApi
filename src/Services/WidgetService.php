<?php

namespace App\Services;

use App\Entity\Widget;
use Doctrine\ORM\EntityManagerInterface;

class WidgetService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $data
     * @param Widget|null $widget
     * @return Widget
     */
    public function createOrUpdate(array $data, Widget $widget=null):Widget {
        if($widget===null) {
            $widget=new Widget();
            $this->entityManager->persist($widget);
        }
        $widget->fromArray($data);
        $this->entityManager->flush();
        return $widget;
    }
}