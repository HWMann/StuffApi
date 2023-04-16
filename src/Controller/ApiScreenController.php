<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Screen;
use App\Services\ActorService;
use App\Services\ScreenService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/screen', name: 'screen')]
class ApiScreenController extends BaseController
{
    #[Route('', name: '_create', methods: ["PUT"])]
    #[Route('/{screen}', name: '_update', methods: ["POST"])]
    public function createOrUpdateAction(ScreenService $screenService, ?Screen $screen = null): JsonResponse
    {
        $actor = $screenService->createOrUpdate($this->req,$screen);
        $this->mqtt("/screen/update",$actor->toArray());
        return $this->success("Screen ".$actor->getName()." saved!");
    }

    #[Route('/{screen}', name: '_edit', methods: ["GET"])]
    public function editAction(Screen $screen): JsonResponse
    {
        return new JsonResponse($screen->toArray());
    }

    #[Route('/{screen}', name: '_delete', methods: ["DELETE"])]
    public function deleteAction(Screen $screen): JsonResponse
    {
        $this->mqtt("/screen/remove",$screen->toArray());
        $this->entityManager->remove($screen);
        $this->entityManager->flush();
        return $this->success("Deleted ".$screen->getName());
    }


}