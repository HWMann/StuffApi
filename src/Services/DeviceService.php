<?php

namespace App\Services;

use App\Entity\Device;
use Doctrine\ORM\EntityManagerInterface;

class DeviceService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $data
     * @param Device|null $device
     * @return Device
     */
    public function createOrUpdate(array $data, Device $device=null):Device {
        if($device===null) {
            $device=new Device();
            $this->entityManager->persist($device);
        }
        $device->fromArray($data);
        $this->entityManager->flush();
        return $device;
    }
}