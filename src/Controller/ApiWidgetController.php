<?php

namespace App\Controller;

use App\Entity\Widget;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/widget', name: 'widget')]
class ApiWidgetController extends BaseController
{
    #[Route('', name: '_save', methods: ["PUT","POST"])]
    public function saveAction(): JsonResponse
    {
        $widget=$this->deserialize($this->json,Widget::class);
        $this->entityManager->flush();
        $this->mqtt("/widget/update",$this->serialize($widget));
        $this->mqtt("Honeydew/reload",null,true);
        return $this->success("widgets.toasts.saved",["widget" => $widget->getName()]);
    }

    #[Route('/{widget}', name: '_edit', methods: ["GET"])]
    public function editAction(Widget $widget): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serialize($widget));
    }

    #[Route('/{widget}', name: '_delete', methods: ["DELETE"])]
    public function deleteAction(Widget $widget): JsonResponse
    {
        $this->mqtt("/widget/remove",$this->serialize($widget));
        $this->mqtt("Honeydew/reload",null,true);
        $this->entityManager->remove($widget);
        $this->entityManager->flush();
        return $this->success("Widget ".$widget->getName()." deleted!");
    }
}