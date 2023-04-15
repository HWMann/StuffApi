<?php

namespace App\Controller;

use App\Services\JsonHelper;
use App\Services\MqttService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class BaseController extends AbstractController
{
    public ?array $req = null;
    public ?string $json = null;
    public ?array $files = null;

    public EntityManagerInterface $entityManager;
    private MqttService $mqttService;
    public JsonHelper $helper;

    public function __construct(
        RequestStack $request,
        EntityManagerInterface $entityManager,
        MqttService $mqttService,
        JsonHelper $jsonHelper
    ) {
        $this->json=$request->getCurrentRequest()->getContent();
        if($this->json) {
            $this->req=json_decode($this->json,true);
        }

        $this->entityManager = $entityManager;
        $this->mqttService = $mqttService;
        $this->request = $request;
        $this->helper = $jsonHelper;
    }

    /**
     * @return JsonResponse
     */
    public function ok():JsonResponse {
        return new JsonResponse(["success" => true]);
    }

    /**
     * @param string $topic
     * @param mixed $data
     */
    public function mqtt(string $topic, mixed $data):void {
        $this->mqttService->publish($topic,$data);
    }

    /**
     * @param $message
     * @return void
     */
    public function success($message):void {
        $this->mqttService->publish("MyStuffRestSays/message",[
            "type" => "success",
            "title" => "Das hat geklappt...",
            "message" => $message
        ]);
    }

    /**
     * @param mixed $data
     * @return JsonResponse
     */
    public function dump(mixed $data):JsonResponse {
        $result="no_data";
        if($data!==null) $result=print_r($data,true);

        return new JsonResponse($result);

    }
}