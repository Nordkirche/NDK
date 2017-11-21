<?php

$configuration = include '1_basic_setup.php';

$api = new \Nordkirche\Ndk\Api($configuration);

$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);

$result = $repository->get(new \Nordkirche\Ndk\Domain\Query\InstitutionQuery());

foreach ($result as $institution) {
    echo $institution->getLabel() . ' (' . $institution->getName() . ')' . PHP_EOL;
}