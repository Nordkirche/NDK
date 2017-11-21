<?php

/** @var \Nordkirche\Ndk\Configuration $configuration */
$configuration = include '1_basic_setup.php';


$configuration->setHttpCacheProvider(new \Doctrine\Common\Cache\FilesystemCache('./cache/http'));
$configuration->setReflectionCacheProvider(new \Doctrine\Common\Cache\FilesystemCache('./cache/reflection'));
$configuration->setDependencyInjectionCacheProvider(new \Doctrine\Common\Cache\FilesystemCache('./cache/di'));

$api = new \Nordkirche\Ndk\Api($configuration);
$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);
$result = $repository->get(new \Nordkirche\Ndk\Domain\Query\InstitutionQuery());