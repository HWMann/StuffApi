<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;

class MqttService
{
    private MqttClient $mqttClient;

    public function __construct()
    {
        $this->mqttClient = new MqttClient("kermit",1883,"theRest");
        $this->mqttClient->connect();
    }

    public function publish(string $topic, mixed $data) {
        if(is_array($data)) $data=json_encode($data);
        $this->mqttClient->publish("MyStuffRestSays".$topic,$data,0);
    }
}