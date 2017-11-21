<?php

$configuration = include '1_basic_setup.php';

$api = new \Nordkirche\Ndk\Api($configuration);

$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);

$query = new \Nordkirche\Ndk\Domain\Query\InstitutionQuery();
$result = $repository->get($query);
$instiution = $result->current();

$uri = (string)$instiution; // napi://resource/institution/1930

echo 'NDK Resource URI: ' . $result->current() . PHP_EOL;

/** @var \Nordkirche\Ndk\Service\NapiService $napi */
$napi = $api->factory(\Nordkirche\Ndk\Service\NapiService::class);
$result = $napi->resolveUrl($uri);

echo 'Resolved NDK URI: ' . $result->getName() . ' (' . $result->getId() . ')' . PHP_EOL;
