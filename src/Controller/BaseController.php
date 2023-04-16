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

    // for old dingsis
    public function ok(string $message="Great success!", string $summary="Great success!"):JsonResponse {
        return $this->success($message,$summary);
    }
    /**
     * @return JsonResponse
     */
    public function success(string $message="Great success!", string $summary="Great success!"):JsonResponse {
        return new JsonResponse([
            "success" => true,
            "message" => $message,
            "summary" => $summary,
            "severity" => "success"
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function info(string $message="Great info!", string $summary="Great info!"):JsonResponse {
        return new JsonResponse([
            "success" => true,
            "message" => $message,
            "summary" => $summary,
            "severity" => "info"
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function warn(string $message="Great warning!", string $summary="Great warning!"):JsonResponse {
        return new JsonResponse([
            "success" => true,
            "message" => $message,
            "summary" => $summary,
            "severity" => "warn"
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function error(string $message="Great error!", string $summary="Great error!"):JsonResponse {
        return new JsonResponse([
            "success" => true,
            "message" => $message,
            "summary" => $summary,
            "severity" => "error"
        ]);
    }

    /**
     * @param string $topic
     * @param mixed $data
     */
    public function mqtt(string $topic, mixed $data):void {
        $this->mqttService->publish($topic,$data);
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