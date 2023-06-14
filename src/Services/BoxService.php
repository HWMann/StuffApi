<?php

namespace App\Services;

use App\Entity\Box;
use App\Repository\BoxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class BoxService
{
    private EntityManagerInterface $entityManager;
    private BoxRepository $boxRepository;
    private MqttService $mqtt;

    /**
     * @param EntityManagerInterface $entityManager
     * @param BoxRepository $boxRepository
     * @param MqttService $mqtt
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        BoxRepository $boxRepository,
        MqttService $mqtt
    ) {
        $this->entityManager = $entityManager;
        $this->boxRepository = $boxRepository;
        $this->mqtt = $mqtt;
    }


    /**
     * @param Box|null $box
     */
    public function list(Box $box=null): BoxService
    {
        $this->mqtt->publish("box/list",$this->boxRepository->getList($box));
        return $this;
    }

    /**
     * @param Box $box
     * @return BoxService
     */
    public function delete(Box $box):BoxService {
        $box->setTrashed(true);
            $this->mqtt->publish("/box/remove",["id" => $box->getId()]);
        return $this;
    }

    public function breadCrumb(Box|null $box): array{
        $breadCrumb=[];
        if($box!==null) {
            do {
                $breadCrumb[]=[
                    "id" => $box->getId(),
                    "label" => $box->getName()
                ];
                $box=$box->getParent();
            } while($box!==null);
        }

        $breadCrumb[]=[
            "id" => 0,
            "label" => "root"
        ];
        return array_reverse($breadCrumb);
    }

    /**
     * @param Box|null $box
     * @param array $data
     * @return JsonResponse
     */
    public function updateOrCreate(?Box $box, array $data):JsonResponse
    {
        if($box===null) {
            $this->createBoxes($data);
        } else {
            $oldParent=$box->getParent();
            $box
                ->setName($data["name"])
                ->setShort($data["short"])
                ->setParent($this->boxRepository->find($data["parent"]["id"]));
            if($oldParent===$box->getParent()) {
                $this->mqtt->publish("/box/update",[
                    "id" => $box->getId(),
                    "name" => $box->getName(),
                    "short" => $box->getShort()
                ]);
            } else {
                $this->mqtt->publish("/box/remove",["id" => $box->getId()]);
            }
        }
        return new JsonResponse("ok");
    }

    /**
     * @param array $data
     * @return void
     */
    private function createBoxes(array $data)
    {
        $parentBox=$this->boxRepository->find($data["parent"]["id"]);

        if($data["range"][0]===$data["range"][1]) {
            $this->createBox($data["name"],$data["short"],$parentBox);
        } else {
            for($i=$data["range"][0];$i<=$data["range"][1];$i++) {
                if($data["range"][0]>9 || $data["range"][1]>9) {
                    $number=sprintf("%02d",$i);
                } else {
                    $number=$i;
                }
                $this->createBox($data["name"]." ".$number,$data["short"].$number,$parentBox);
            }
        }
    }

    /**
     * @param string $name
     * @param string $short
     * @return bool
     */
    private function createBox(?string $name, ?string $short, ?Box $parentBox ): bool
    {
        $box=new Box();

        $box
            ->setName($name)
            ->setShort($short)
            ->setParent($parentBox)
        ;
        $this->entityManager->persist($box);

        $this->mqtt->publish("/box/update",[
            "id" => $box->getId(),
            "name" => $box->getName(),
            "short" => $box->getShort()
        ]);
        return true;
    }

    public function tree(): JsonResponse {


    }

    /**
     * @param Box|null $box
     * @return JsonResponse
     */
    public function children(?Box $box = null): JsonResponse {
        $data=$this->boxRepository->root($box);
        if($box!==null) {
            array_unshift($data,["id" => ($box->getParent()!==null) ? $box->getParent()->getId() : 0,"name" => "..","short" => ".."]);
        }
        return new JsonResponse($data);
    }
}