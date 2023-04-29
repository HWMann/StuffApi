<?php

namespace App\Controller;

use App\Entity\Widget;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actions')]
class ApiActionsController extends BaseController
{
    #[Route('/{widget}')]
    public function listAction(Widget $widget): JsonResponse
    {
        return $this->sResponse($widget->getActions());
    }
}