<?php

namespace App\Controller;

use App\Entity\Thing;
use App\Repository\ActorRepository;
use App\Repository\SensorRepository;
use App\Services\StorageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sensors', name: '_sensors')]
class ApiSensorsController extends BaseController
{
    #[Route('', name: '_list', methods: ["GET"])]
    public function listAction(SensorRepository $sensorRepository):JsonResponse
    {
        return new JsonResponse($sensorRepository->getList());
    }
}