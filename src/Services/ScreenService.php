<?php

namespace App\Services;

use App\Entity\Screen;
use Doctrine\ORM\EntityManagerInterface;

class ScreenService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $data
     * @param Screen|null $screen
     * @return Screen
     */
    public function createOrUpdate(array $data, Screen $screen=null):Screen {
        if($screen===null) {
            $screen=new Screen();
            $this->entityManager->persist($screen);
        }
        $screen->fromArray($data);
        $this->entityManager->flush();
        return $screen;
    }
}