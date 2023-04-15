<?php

namespace App\Controller;

use App\Entity\Darter;
use App\Repository\DarterRepository;
use App\Services\MqttService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/darter', name: 'darter')]
class DarterController extends BaseController
{
    #[Route("/list", name: "_list", methods: "GET")]
    public function list(DarterRepository $darterRepository): JsonResponse
    {
        $result=$this->serialize($darterRepository->findAll());
        return JsonResponse::fromJsonString($result);
    }

    #[Route("/edit/{darter}", name: "_edit", methods:["GET"])]
    public function edit(Darter $darter): JsonResponse
    {
        $res=$this->serialize($darter);
        return JsonResponse::fromJsonString($res);
    }

    #[Route("/store/{darter}", name: "_store", methods:["POST"])]
    public function store(DarterRepository $darterRepository, MqttService $mqttService, Darter $darter = null): JsonResponse
    {
        if($darter===null) {
            $darter=new Darter();
            $this->entityManager->persist($darter);
        }

        $darter=$this->deserialize($this->reqJSON,Darter::class, $darter);

        $this->entityManager->flush();

        $result=$this->serialize($darter);
        $mqttService->publish("rest/darter/update",$result);
        return JsonResponse::fromJsonString($result);
    }

}