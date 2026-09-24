<?php

/** @var \Nordkirche\Ndk\Configuration $configuration */
$configuration = include '1_basic_setup.php';


$configuration->setHttpCacheProvider(new \Symfony\Component\Cache\Adapter\FilesystemAdapter('ndk_http', 0, './cache'));
$configuration->setReflectionCacheProvider(new \Symfony\Component\Cache\Adapter\FilesystemAdapter('ndk_reflection', 0, './cache'));

$api = new \Nordkirche\Ndk\Api($configuration);
$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);
$result = $repository->get(new \Nordkirche\Ndk\Domain\Query\InstitutionQuery());