<?php

namespace App\Controller;

use App\Entity\Box;
use App\Repository\BoxRepository;
use PhpMqtt\Client\Exceptions\DataTransferException;
use PhpMqtt\Client\Exceptions\RepositoryException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/boxes', name: 'boxes')]
class ApiBoxesController extends BaseController
{
    /**
     * @param Box|null $box
     * @param BoxRepository $boxRepository
     * @return void
     * @throws DataTransferException
     * @throws RepositoryException
     */
    #[Route('/{box}', name: '_list')]
    public function listAction(?Box $box, BoxRepository $boxRepository): JsonResponse
    {
        $this->mqtt("/boxes/list", $this->serialize($boxRepository->findBy(["parent" => $box, "trashed" => false]), "list"));
        $this->mqtt("/boxes/breadcrumb", $this->serialize($boxRepository->getBreadCrumb($box), "list"));
        return $this->quiet();
    }
}