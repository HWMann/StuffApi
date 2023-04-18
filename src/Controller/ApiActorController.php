<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use App\Services\ActorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use JsonPath\JsonObject;

#[Route('/actor', name: '_actor')]
class ApiActorController extends BaseController
{
    #[Route('/updateStatus', name: '_update_status', methods: ["POST"])]
    public function updateStatusAction(ActorRepository $actorRepository): JsonResponse
    {
        $actor=$actorRepository->findOneBy(["statusTopic" => $this->req["t"]]);

        if($actor!==null) {
            $jsonPath=$actor->getJsonPath();

            if($jsonPath!==null) {
                $jsonObject=new JsonObject(json_decode($this->req["s"]));
                $stat=$jsonObject->get($jsonPath);
                $stat=($stat[0]===1) ? true : false;
            } else {
                $stat=($this->req["s"]===1) ? true : false;
            }

            $actor->setStatus($stat);
            $this->entityManager->flush();
            $this->mqtt("/actor/status/update/".$actor->getId(),$stat);
            $this->mqtt("Honeydew/reload",null,true);
            return new JsonResponse(["data" => $stat]);
        }

        return $this->ok();
    }


    #[Route('', name: '_create', methods: ["PUT"])]
    #[Route('/{actor}', name: '_update', methods: ["POST"])]
    public function createOrUpdateAction(ActorService $actorService, ?Actor $actor = null): JsonResponse
    {
        $actor = $actorService->createOrUpdate($this->req,$actor);
        $this->mqtt("/actor/update",$actor->toArray());
        $this->mqtt("Honeydew/reload",null,true);
        return $this->ok();
    }

    #[Route('/{actor}', name: '_edit', methods: ["GET"])]
    public function editAction(Actor $actor): JsonResponse
    {
        return new JsonResponse($actor->toArray());
    }

    #[Route('/{actor}', name: '_delete', methods: ["DELETE"])]
    public function deleteAction(Actor $actor): JsonResponse
    {
        $this->mqtt("/actor/remove",$actor->toArray());
        $this->mqtt("Honeydew/reload",null,true);
        $this->entityManager->remove($actor);
        $this->entityManager->flush();
        return $this->ok();
    }




}