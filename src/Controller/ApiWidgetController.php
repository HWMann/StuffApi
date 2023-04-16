<?php

namespace App\Controller;

use App\Entity\Widget;
use App\Services\WidgetService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/widget', name: 'widget')]
class ApiWidgetController extends BaseController
{
    #[Route('', name: '_create', methods: ["PUT"])]
    #[Route('/{widget}', name: '_update', methods: ["POST"])]
    public function createOrUpdateAction(WidgetService $widgetService, ?Widget $widget = null): JsonResponse
    {
        $widget = $widgetService->createOrUpdate($this->req,$widget);
        $this->mqtt("/widget/update",$widget->toArray());
        return $this->success("Widget ".$widget->getName()." saved!");
    }

    #[Route('/{widget}', name: '_edit', methods: ["GET"])]
    public function editAction(Widget $widget): JsonResponse
    {
        return new JsonResponse($widget->toArray());
    }

    #[Route('/{widget}', name: '_delete', methods: ["DELETE"])]
    public function deleteAction(Widget $widget): JsonResponse
    {
        $this->mqtt("/widget/remove",$widget->toArray());
        $this->entityManager->remove($widget);
        $this->entityManager->flush();
        return $this->success("Widget ".$widget->getName()." deleted!");
    }
}