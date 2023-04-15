<?php

namespace App\Services;

use App\Repository\ThingRepository;

class ThingService
{
    private ThingRepository $thingRepository;

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function list(): array
    {
        try {
            $result=$this->thingRepository->list();
        } catch(\Exception $e) {
            throw($e["message"]);
        }

        return $result;
    }
}