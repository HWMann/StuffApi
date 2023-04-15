<?php

namespace App\Controller;

use App\Entity\Storage;
use App\Entity\Thing;
use App\Repository\BoxRepository;
use App\Services\StorageService;
use App\Services\TagService;
use App\Services\ThingService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/thing', name: 'thing')]
class ApiThingController extends BaseController
{
    /**
     * @param ThingService $thingService
     * @return JsonResponse
     */
    #[Route('/list', name: '_list', methods: ["GET"])]
    public function listThingsAction(ThingService $thingService): JsonResponse
    {
        $this->mqtt("/thing/list", [
            "items" => $thingService->list(),
        ]);
        return $this->ok();

    }

    /**
     * @param Thing $thing
     * @return JsonResponse
     */
    #[Route('/edit/{thing}', name: '_edit', methods: ["GET"])]
    public function editAction(Thing $thing): JsonResponse
    {
        return new JsonResponse($thing->toArray());
    }

    /**
     * @param Thing $thing
     * @return JsonResponse
     */
    #[Route('/delete/{thing}', name: '_delete', methods: "GET")]
    public function deleteAction(Thing $thing): JsonResponse
    {
        $this->mqtt("/thing/remove",[
            "id" => $thing->getId()
        ]);
        return $this->ok();
    }

    #[Route('/create', name: '_create', methods: ["POST"])]
    public function createAction(TagService $tagService, BoxRepository $boxRepository): JsonResponse
    {
        $thing=Thing::create($this->req);
        $this->entityManager->persist($thing);
        $this->entityManager->flush();
        $this->mqtt("/thing/append",$thing->toArray());

        $tagService->addTags($thing->getTags());

        if($this->req["quantity"]!==null && $this->req["box"]!==null) {
            $storage=new Storage();
            $this->entityManager->persist($storage);
            $storage
                ->setQty($this->req["quantity"])
                ->setThing($thing)
                ->setBox($boxRepository->find($this->req["box"]["id"]));
            $this->entityManager->flush();
        }

        return $this->ok();
    }

    /**
     * @param Thing $thing
     * @param TagService $tagService
     * @return JsonResponse
     */
    #[Route('/update/{thing}', name: '_update', methods: ["POST"])]
    public function updateAction(Thing $thing, TagService $tagService, BoxRepository $boxRepository): JsonResponse
    {
        $thing->fromArray($this->req);
        $this->entityManager->flush();
        $this->mqtt("/thing/replace",$thing->toArray());

        $tagService->addTags($thing->getTags());

        if($this->req["quantity"]!==null && $this->req["box"]!==null) {
            $storage=new Storage();
            $this->entityManager->persist($storage);
            $storage
                ->setQty($this->req["quantity"])
                ->setThing($thing)
                ->setBox($boxRepository->find($this->req["box"]["id"]));
            $this->entityManager->flush();
        }


        return $this->ok();
    }

    #[Route('/stock/{thing}', name: '_stock', methods: ["GET"])]
    public function stockAction(Thing $thing, StorageService $storageService): JsonResponse
    {
        return $storageService->getStock($thing);
    }

    #[Route('/image/{thing}', name: '_image', methods: ["POST"])]
    public function imageAction(Thing $thing): JsonResponse
    {
        return $this->dump($this->req);
    }


}