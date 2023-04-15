<?php

namespace App\Controller;

use Doctrine\ORM\Query\ResultSetMapping;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/radiator', name: 'radiator')]
class RadiatorController extends BaseController
{
    #[Route("/curves", name: "_curves", methods: "GET")]
    public function curves(): JsonResponse
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('temp', 'temp');

        $query = $this->entityManager->createNativeQuery('SELECT temp FROM temp_wohnzimmer ORDER BY stamp DESC limit 0,96', $rsm);
        $data_wohnzimmer = $query->getSingleColumnResult();
        $query = $this->entityManager->createNativeQuery('SELECT `valve` FROM temp_wohnzimmer ORDER BY stamp  DESC limit 0,96', $rsm);
        $data_wohnzimmer_valve = $query->getSingleColumnResult();

        $query = $this->entityManager->createNativeQuery('SELECT temp FROM temp_schlafzimmer ORDER BY stamp  DESC limit 0,96', $rsm);
        $data_schlafzimmer = $query->getSingleColumnResult();
        $query = $this->entityManager->createNativeQuery('SELECT `valve` FROM temp_schlafzimmer ORDER BY stamp  DESC limit 0,96', $rsm);
        $data_schlafzimmer_valve = $query->getSingleColumnResult();

        $query = $this->entityManager->createNativeQuery('SELECT temp FROM temp_buero ORDER BY stamp  DESC limit 0,96', $rsm);
        $data_buero = $query->getSingleColumnResult();
        $query = $this->entityManager->createNativeQuery('SELECT `valve` FROM temp_buero ORDER BY stamp  DESC limit 0,96', $rsm);
        $data_buero_valve = $query->getSingleColumnResult();

        $query = $this->entityManager->createNativeQuery('SELECT stamp FROM temp_buero ORDER BY stamp  DESC limit 0,96', $rsm);
        $zeiten = $query->getSingleColumnResult();


        $data_wohnzimmer_valve=array_map(fn($v): float => $v/10,$data_wohnzimmer_valve);
        $data_schlafzimmer_valve=array_map(fn($v): float => $v/10,$data_schlafzimmer_valve);
        $data_buero_valve=array_map(fn($v): float => $v/10,$data_buero_valve);

        return new JsonResponse([
            "datasets" => [
                [
                    "data" => array_map('floatval', array_reverse($data_wohnzimmer)),
                    "label" => "Wohnzimmer",
                    "fill" => false,
                    "borderColor" => 'red',
                ],
                [
                    "data" => array_map('floatval', array_reverse($data_wohnzimmer_valve)),
                    "label" => "Wohnzimmer Öffnung",
                    "fill" => false,
                    "borderColor" => '#990000',
                ],
                [
                    "data" => array_map('floatval', array_reverse($data_schlafzimmer)),
                    "label" => "Schlafzimmer",
                    "fill" => false,
                    "borderColor" => 'green',
                ],
                [
                    "data" => array_map('floatval', array_reverse($data_schlafzimmer_valve)),
                    "label" => "Schlafzimmer Öffnung",
                    "fill" => false,
                    "borderColor" => '#009900',
                ],
                [
                    "data" => array_map('floatval', array_reverse($data_buero)),
                    "label" => "Büro",
                    "fill" => false,
                    "borderColor" => 'blue',
                ],
                [
                    "data" => array_map('floatval', array_reverse($data_buero_valve)),
                    "label" => "Büro Öffnung",
                    "fill" => false,
                    "borderColor" => '#000099',
                ]
            ],
            "labels" => array_reverse(array_map(function($x) {
                return date("H:i",$x);
            },$zeiten))


        ]);
    }
}