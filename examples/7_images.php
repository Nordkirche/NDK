<?php

/** @var \Nordkirche\Ndk\Configuration $configuration */
$configuration = include '1_basic_setup.php';

$api = new \Nordkirche\Ndk\Api($configuration);
$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);

/** @var \Nordkirche\Ndk\Domain\Model\Institution\Institution $instituion */
$instituion = $repository->getById(1930);

/** @var string $imageUrl */
$imageUrl = $instituion->getLogo()->render(150);

/** @var \Nordkirche\Ndk\Domain\Model\File\Details $imageDetails */
$imageDetails = $instituion->getLogo()->getDetails();

/** @var string $copyright */
$copyright = $imageDetails->getCopyright();

echo $imageUrl . PHP_EOL;

echo $copyright . PHP_EOL;