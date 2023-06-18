<?php

namespace App\Controller;

use App\Entity\Box;
use App\Repository\BoxRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/box-selector', name: '_box_selector')]
class ApiBoxSelectorController extends BaseController
{
    /**
     * @param Box|null $parent
     * @param Box|null $except
     * @param BoxRepository $boxRepository
     * @return JsonResponse
     */
    #[Route('/{parent}/{except}', name: '_list_boxes_except', methods: ["GET"])]
    public function listBoxesExceptAction(?Box $parent, ?Box $except, BoxRepository $boxRepository):JsonResponse
    {
        $data=$boxRepository->findForBoxSelector($parent,$except);
        return JsonResponse::fromJsonString($this->serialize($data));
    }
}