<?php

namespace App\Controller;

use App\Repository\ScreenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/screens', name: 'screens')]
class ApiScreensController extends BaseController
{
    #[Route('', name: '_list', methods: ["GET"])]
    public function listAction(ScreenRepository $screenRepository):JsonResponse
    {
        return new JsonResponse($screenRepository->getList());
    }
}