<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Services\ActorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actor', name: '_actor')]
class ApiActorController extends BaseController
{
    #[Route('', name: '_create', methods: ["PUT"])]
    #[Route('/{actor}', name: '_update', methods: ["POST"])]
    public function createOrUpdateAction(ActorService $actorService, ?Actor $actor = null): JsonResponse
    {
        $actor = $actorService->createOrUpdate($this->req,$actor);
        $this->mqtt("/actor/update",$actor->toArray());
        return $this->ok();
    }

    #[Route('/{actor}', name: '_edit', methods: ["GET"])]
    public function editAction(Actor $actor): JsonResponse
    {
        return new JsonResponse($actor->toArray());
    }
}