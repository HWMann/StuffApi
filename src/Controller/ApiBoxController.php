<?php

namespace App\Controller;

use App\Entity\Box;
use App\Repository\BoxRepository;
use App\Services\BoxService;
use Doctrine\Common\Collections\Criteria;
use PhpMqtt\Client\Exceptions\DataTransferException;
use PhpMqtt\Client\Exceptions\RepositoryException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/box', name: 'box')]
class ApiBoxController extends BaseController
{
    /**
     * @param BoxService $boxService
     * @return JsonResponse
     */
    #[Route('/list/parents', name: 'box_list_parents', methods: ["GET"])]
    public function boxListParents(BoxService $boxService):JsonResponse {
        return $boxService->parents();
    }

    /**
     * @param BoxService $boxService
     * @param Box|null $box
     * @return void
     * @throws DataTransferException
     * @throws RepositoryException
     */
    #[Route('/list/{box}', name: 'box_list', methods: ["GET"])]
    public function get(BoxService $boxService, Box $box=null):void {
        $items=$this->helper->list(Box::class,["id","short","name"],
            (new Criteria())
                ->where(Criteria::expr()->eq("parent",$box))
                ->andWhere(Criteria::expr()->eq("trashed",false))
        );
        $this->mqtt("/box/list",["items" => $items, "breadCrumb" => $boxService->breadCrumb($box)]);
    }

    /**
     * @param Box $box
     * @return JsonResponse
     */
    #[Route('/store/{box}', name: "box_store", methods: ["POST"])]
    public function boxStoreAction(BoxService $boxService,Box $box = null): JsonResponse
    {
        $boxService->updateOrCreate($box,$this->req);
        $this->entityManager->flush();
        $this->mqtt("/box/update", $box);
        return $this->ok();
    }

    /**
     * @param Box $box
     * @return JsonResponse
     */
    #[Route('/edit/{box}', name: "box_edit", methods: ["GET"])]
    public function boxEditAction(Box $box):JsonResponse {
        return new JsonResponse($box->toArray());
    }

    /**
     * @param Box $box
     * @param BoxService $boxService
     */
    #[Route('/delete/{box}', name: 'box_delete', methods: ["GET"])]
    public function deleteBoxAction(Box $box, BoxService $boxService, BoxRepository $boxRepository):JsonResponse
    {
        $boxService->delete($box);
        $this->entityManager->flush();
        return $this->ok();
    }

    /**
     * @param BoxService $boxService
     * @return JsonResponse
     */
    #[Route('/tree', name: 'box_tree', methods: ["GET"])]
    public function boxTreeAction(BoxService $boxService): JsonResponse
    {
        return $boxService->tree();
    }

    #[Route('/root', name: '_root/', methods: ["GET"])]
    public function rootAction(BoxService $boxService): JsonResponse
    {
        return $boxService->root();
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