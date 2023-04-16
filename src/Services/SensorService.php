<?php

namespace App\Services;

use App\Entity\Sensor;
use Doctrine\ORM\EntityManagerInterface;

class SensorService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $data
     * @param Sensor|null $sensor
     * @return Sensor
     */
    public function createOrUpdate(array $data, Sensor $sensor=null):Sensor {
        if($sensor===null) {
            $sensor=new Sensor();
            $this->entityManager->persist($sensor);
        }
        $sensor->fromArray($data);
        $this->entityManager->flush();
        return $sensor;
    }
}