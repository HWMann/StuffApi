<?php

namespace App\Controller;

use App\Services\JsonHelper;
use App\Services\MqttService;
use Doctrine\ORM\EntityManagerInterface;
#use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializerInterface;
use PhpMqtt\Client\Exceptions\DataTransferException;
use PhpMqtt\Client\Exceptions\RepositoryException;
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
        RequestStack           $request,
        EntityManagerInterface $entityManager,
        MqttService            $mqttService,
        JsonHelper             $jsonHelper,
        SerializerInterface    $serializer
    )
    {
        $this->json = $request->getCurrentRequest()->getContent();
        if ($this->json) {
            $this->req = json_decode($this->json, true);
        }

        $this->entityManager = $entityManager;
        $this->mqttService = $mqttService;
        $this->request = $request;
        $this->helper = $jsonHelper;
        $this->serializer = $serializer;
    }

    /**
     * @param mixed $data
     * @return string
     */
    public function serialize(mixed $data): string
    {
        return $this->serializer->serialize($data, 'json');
    }

    /**
     * @param mixed $data
     * @return JsonResponse
     */
    public function sResponse(mixed $data): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serialize($data));
    }

    /**
     * @param string $json
     * @param string $className
     * @return mixed
     */
    public function deserialize(string $json, string $className): mixed
    {
        $result = $this->serializer->deserialize($json, $className, "json");
        if($result->getId()===0) $this->entityManager->persist($result);
        return $result;
    }

    // for old dingsis
    public function ok(string $message = "Great success!", string $summary = "Great success!"): JsonResponse
    {
        return $this->success($message, $summary);
    }

    /**
     * @param string $message
     * @param array|null $data
     * @return JsonResponse
     */
    public function success(string $message = "Great success!", string $summary = "Great success!"): JsonResponse
    {
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
    public function info(string $message = "Great info!", string $summary = "Great info!"): JsonResponse
    {
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
    public function warn(string $message = "Great warning!", string $summary = "Great warning!"): JsonResponse
    {
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
    public function error(string $message = "Great error!", string $summary = "Great error!"): JsonResponse
    {
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
     * @param bool $fromRoot
     * @throws DataTransferException
     * @throws RepositoryException
     */
    public function mqtt(string $topic, mixed $data = "", bool $fromRoot = false): void
    {
        $this->mqttService->publish($topic, $data, $fromRoot);
    }

    /**
     * @param mixed $data
     * @return JsonResponse
     */
    public function dump(mixed $data): JsonResponse
    {

    }
}