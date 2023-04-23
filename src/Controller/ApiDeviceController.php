<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Device;
use App\Entity\Thing;
use App\Repository\DeviceRepository;
use App\Services\ActorService;
use App\Services\DeviceService;
use App\Services\StorageService;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/device', name: '_storage')]
class ApiDeviceController extends BaseController
{
    #[Route('/updateStatus', name: '_update_status', methods: ["POST"])]
    public function updateStatusAction(DeviceRepository $deviceRepository)
    {
        $device=$deviceRepository->findOneBy(["name" => $this->req["device"]]);
        $device
            ->setIp($this->req["ip"])
            ->setLastAliveMessage(new DateTime());

        $this->entityManager->flush();
        $this->mqtt("/device/update",$device->toArray());
    }

    #[Route('', name: '_create', methods: ["PUT"])]
    #[Route('/{device}', name: '_update', methods: ["POST"])]
    public function createOrUpdateAction(DeviceService $deviceService, ?Device $device = null): JsonResponse
    {
        $device = $deviceService->createOrUpdate($this->req,$device);
        $this->mqtt("/device/update",$device->toArray());
        return $this->ok();
    }

    #[Route('/{device}', name: '_edit', methods: ["GET"])]
    public function editAction(Device $device): JsonResponse
    {
        return new JsonResponse($device->toArray());
    }




}