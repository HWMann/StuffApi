<?php

namespace App\Controller;

use App\Entity\Screen;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/screen', name: 'screen')]
class ApiScreenController extends BaseController
{
    #[Route('', name: '_create', methods: ["POST","PUT"])]
    public function createOrUpdateAction(): JsonResponse
    {
        $screen=$this->deserialize($this->json,Screen::class);
        $this->entityManager->flush();
        $this->mqtt("/screen/update",$this->serialize($screen));
        $this->mqtt("Honeydew/reload",null,true);
        return $this->success("Screen ".$screen->getName()." saved!");
    }

    #[Route('/{screen}', name: '_edit', methods: ["GET"])]
    public function editAction(Screen $screen): JsonResponse
    {
        return $this->sResponse($screen);
    }

    #[Route('/{screen}', name: '_delete', methods: ["DELETE"])]
    public function deleteAction(Screen $screen): JsonResponse
    {
        $this->mqtt("/screen/remove",$this->serialize($screen));
        $this->mqtt("Honeydew/reload",null,true);
        $this->entityManager->remove($screen);
        $this->entityManager->flush();
        return $this->success("Deleted ".$screen->getName());
    }


}