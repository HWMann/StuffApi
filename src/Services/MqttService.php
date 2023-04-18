<?php

namespace App\Services;

use PhpMqtt\Client\Exceptions\DataTransferException;
use PhpMqtt\Client\Exceptions\RepositoryException;
use PhpMqtt\Client\MqttClient;

class MqttService
{
    private MqttClient $mqttClient;

    public function __construct()
    {
        $this->mqttClient = new MqttClient("kermit",1883,"theRest");
        $this->mqttClient->connect();
    }

    /**
     * @param string $topic
     * @param mixed|null $data
     * @param $fromRoot
     * @return void
     * @throws DataTransferException
     * @throws RepositoryException
     */
    public function publish(string $topic, mixed $data = "", $fromRoot=false) {
        if($data==null) $data="";
        if(is_array($data)) $data=json_encode($data);
        if($fromRoot===false) {
            $this->mqttClient->publish("MyStuffRestSays".$topic,$data,0);
        } else {
            $this->mqttClient->publish($topic,$data,0);
        }

    }
}