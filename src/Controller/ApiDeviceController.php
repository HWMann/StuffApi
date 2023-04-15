<?php

namespace App\Controller;

use App\Entity\Thing;
use App\Services\StorageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/device', name: '_storage')]
class ApiDeviceController extends BaseController
{

}