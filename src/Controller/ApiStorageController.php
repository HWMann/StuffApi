<?php

namespace App\Controller;

use App\Entity\Thing;
use App\Services\StorageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/storage', name: '_storage')]
class ApiStorageController extends BaseController
{
    #[Route('/{thing}', name: '_store', methods: ["PUT"])]
    public function storeAction(Thing $thing, StorageService $storageService): JsonResponse
    {
        $storageService->store($thing,$this->req);
        return $this->ok();
    }

    #[Route('/{thing}', name: '_list', methods: ["GET"])]
    public function listAction(Thing $thing, StorageService $storageService): JsonResponse
    {
        return $storageService->list($thing);
    }


}