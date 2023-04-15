<?php

namespace App\Services;

use App\Entity\Actor;
use Doctrine\ORM\EntityManagerInterface;

class ActorService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $data
     * @param Actor|null $actor
     * @return Actor
     */
    public function createOrUpdate(array $data, Actor $actor=null):Actor {
        if($actor===null) {
            $actor=new Actor();
            $this->entityManager->persist($actor);
        }
        $actor->fromArray($data);
        $this->entityManager->flush();
        return $actor;
    }
}