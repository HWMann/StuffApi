<?php

namespace App\Controller;

use App\Entity\Port;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;

#[Route('/port', name: '_actor')]
class ApiPortController extends BaseController
{
    #[Route('', name: '_save',methods: ["POST"])]
    public function saveAction()
    {
        $port = $this->deserialize($this->json, Port::class);

        $this->entityManager->flush();
        $this->mqtt("/port/update", $this->serialize($port));
        return $this->success("Port " . $port->getName() . " saved!");
    }

    #[Route('/{port}', name: '_delete',methods: ["DELETE"])]
    public function deleteAction(Port $port): JsonResponse
    {
        $this->mqtt("/port/remove",$this->serialize($port));
        $this->entityManager->remove($port);
        $this->entityManager->flush();
        return $this->success("Port " . $port->getName() . " deleted!");
    }
}
