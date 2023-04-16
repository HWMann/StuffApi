<?php

namespace App\Controller;

use App\Repository\WidgetRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/widgets', name: 'widgets')]
class ApiWidgetsController extends BaseController
{
    #[Route('', name: '_list', methods: ["GET"])]
    public function listAction(WidgetRepository $widgetRepository):JsonResponse
    {
        return new JsonResponse($widgetRepository->getList());
    }
}