<?php

namespace App\Controller;

use App\Entity\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/action', name: '_action')]
class ApiActionController extends BaseController
{
    #[Route("", methods: ["post"])]
    public function saveAction():JsonResponse
    {
        $action=$this->deserialize($this->json,Action::class);
        $this->entityManager->flush();
        $this->mqtt("/action/update",$this->serialize($action));
        return $this->ok();
    }

    #[Route("/{action}", methods: ["delete"])]
    public function deleteAction(Action $action):JsonResponse
    {
        $action->setActor(null);
        $action->setPort(null);
        $action->setWidget(null);
        $this->mqtt("/action/remove",$this->serialize($action));
        $this->entityManager->remove($action);
        $this->entityManager->flush();
        return $this->ok();
    }

}