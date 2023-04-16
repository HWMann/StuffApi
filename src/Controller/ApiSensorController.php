<?php

namespace App\Controller;

use App\Entity\Sensor;
use App\Entity\Thing;
use App\Services\SensorService;
use App\Services\StorageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sensor', name: 'sensor')]
class ApiSensorController extends BaseController
{
    #[Route('', name: '_create', methods: ["PUT"])]
    #[Route('/{sensor}', name: '_update', methods: ["POST"])]
    public function createOrUpdateAction(SensorService $sensorService, ?Sensor $sensor = null): JsonResponse
    {
        $actor = $sensorService->createOrUpdate($this->req,$sensor);
        $this->mqtt("/sensor/update",$actor->toArray());
        return $this->ok();
    }

    #[Route('/{sensor}', name: '_edit', methods: ["GET"])]
    public function editAction(Sensor $sensor): JsonResponse
    {
        return new JsonResponse($sensor->toArray());
    }

    #[Route('/{sensor}', name: '_delete', methods: ["DELETE"])]
    public function deleteAction(Sensor $sensor): JsonResponse
    {
        $this->mqtt("/sensor/remove",$sensor->toArray());
        $this->entityManager->remove($sensor);
        $this->entityManager->flush();
        return $this->ok($sensor->getName(). " deleted!");
    }
}