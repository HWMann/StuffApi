<?php

namespace App\Services;

use App\Entity\Storage;
use App\Entity\Thing;
use App\Repository\BoxRepository;
use App\Repository\StorageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class StorageService
{
    private StorageRepository $storageRepository;
    private BoxRepository $boxRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(StorageRepository $storageRepository, BoxRepository $boxRepository, EntityManagerInterface $entityManager)
    {
        $this->storageRepository = $storageRepository;
        $this->boxRepository = $boxRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Thing $thing
     * @param mixed $data
     * @return void
     */
    public function store(Thing $thing, mixed $data): void
    {

        $box = $this->boxRepository->find($data["box"]["id"]);

        $storage = new Storage();
        $storage
            ->setThing($thing)
            ->setBox($box)
            ->setQty($data["quantity"]);
        $this->entityManager->persist($storage);
        $this->entityManager->flush();
    }

    public function list(Thing $thing): JsonResponse
    {
        return new JsonResponse($this->storageRepository->list($thing));
    }
}