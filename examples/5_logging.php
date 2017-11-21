<?php

/** @var \Nordkirche\Ndk\Configuration $configuration */
$configuration = include '1_basic_setup.php';

$logger = new \Monolog\Logger(
    'stdout',
    [new \Monolog\Handler\StreamHandler('php://stdout')]
);

$configuration->setLogger($logger);

$api = new \Nordkirche\Ndk\Api($configuration);
$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);
$result = $repository->get(new \Nordkirche\Ndk\Domain\Query\InstitutionQuery());

foreach ($result as $institution) {
    $institution->getAddress()->getZipCode();
}