<?php

/** @var \Nordkirche\Ndk\Configuration $configuration */
$configuration = include '1_basic_setup.php';

$api = new \Nordkirche\Ndk\Api($configuration);
$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);

/** @var \Nordkirche\Ndk\Domain\Model\Institution\Institution $instituion */
$instituion = $repository->getById(1930);

$imageUrl = $instituion->getLogo()->render(150) . PHP_EOL;

echo $imageUrl . PHP_EOL;