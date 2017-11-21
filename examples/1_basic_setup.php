<?php

include '../vendor/autoload.php';

$configuration = new \Nordkirche\Ndk\Configuration(
    getenv('NAPI_ID'),
    getenv('NAPI_ACCESSTOKEN')
);
$configuration->setNapiHost('www.nordkirche.de')->setNapiPath('api/');

return $configuration;