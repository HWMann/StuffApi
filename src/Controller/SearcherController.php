<?php

namespace App\Controller;

use App\Repository\BoxRepository;
use App\Repository\ThingRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/searcher', name: 'searcher')]
class SearcherController extends BaseController
{
    /**
     * @param string|null $searchTerm
     * @return JsonResponse
     */
    #[Route('/{searchTerm}', name: 'search', methods: ["GET"])]
    public function search(?string $searchTerm, ThingRepository $thingRepository, BoxRepository $boxRepository): JsonResponse
    {
        return new JsonResponse([
            "things" => $thingRepository->search($searchTerm),
            "boxes" => $boxRepository->search($searchTerm),
            "foods" => null
        ]);
    }
}
