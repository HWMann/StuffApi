<?php

namespace App\Controller;

use App\Repository\BoxRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

#[Route('/boxes', name: 'boxes')]
class ApiBoxesController extends BaseController
{
    #[Route('', name: '_list')]
    public function listAction(BoxRepository $boxRepository):JsonResponse
    {
        $data=$boxRepository->findBy(["parent" => null]);

        return JsonResponse::fromJsonString($this->serialize($data));
    }
}