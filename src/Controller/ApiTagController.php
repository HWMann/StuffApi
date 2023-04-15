<?php

namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tag', name: 'tag')]
class ApiTagController extends BaseController
{
    #[Route('/list', name: '_list', methods: ["GET"])]
    public function listAction(TagRepository $tagRepository): JsonResponse
    {
        return new JsonResponse($tagRepository->getList());
    }

}