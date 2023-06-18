<?php

namespace App\Controller;

use App\Entity\Box;
use App\Repository\BoxRepository;
use App\Services\BoxService;
use PhpMqtt\Client\Exceptions\DataTransferException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/boxes', name: 'boxes')]
class ApiBoxesController extends BaseController
{
    /**
     * @param Box|null $box
     * @param BoxRepository $boxRepository
     * @return void
     */
    #[Route('/{box}', name: '_list')]
    public function listAction(?Box $box, BoxRepository $boxRepository): JsonResponse
    {
        $this->mqtt("/boxes/list", $this->serialize($boxRepository->findBy(["parent" => $box, "trashed" => false]), "list"));
        $this->mqtt("/boxes/breadcrumb", $this->serialize($boxRepository->getBreadCrumb($box), "list"));
        return $this->quiet();
    }

    /**
     * @param Box|null $box
     * @param BoxService $boxService
     * @return JsonResponse
     */
    #[Route('/children/{box}', name: '_children/', methods: ["GET"])]
    public function childrenAction(BoxService $boxService, ?Box $box=null): JsonResponse
    {
        return $boxService->children($box);
    }
}