<?php

namespace App\Controller;

use App\Repository\ActorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actors', name: '_actors')]
class ApiActorsController extends BaseController
{
    #[Route('', name: '_list', methods: ["GET"])]
    public function listAction(ActorRepository $actorRepository):JsonResponse
    {
        return JsonResponse::fromJsonString($this->serialize($actorRepository->findAll()));
    }
}