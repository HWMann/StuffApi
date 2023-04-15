<?php

namespace App\Controller;

use App\Entity\Thing;
use App\Repository\DeviceRepository;
use App\Services\StorageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/devices', name: '_devices')]
class ApiDevicesController extends BaseController
{
    #[Route('', name: '_list', methods: ["GET"])]
    public function listAction(DeviceRepository $deviceRepository):JsonResponse
    {
        return new JsonResponse($deviceRepository->getList());
    }
}