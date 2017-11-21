<?php

$configuration = include '1_basic_setup.php';

$api = new \Nordkirche\Ndk\Api($configuration);

$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);

$query = new \Nordkirche\Ndk\Domain\Query\InstitutionQuery();
$result = $repository->get($query);


echo PHP_EOL . "- - - - - - - without address relations included - - - - - - -" . PHP_EOL;

/** @var \Nordkirche\Ndk\Domain\Model\Institution\Institution $institution */
foreach ($result as $institution) {
    echo $institution->getAddress()->getZipCode() . PHP_EOL;
}



sleep(2);



$query = (new \Nordkirche\Ndk\Domain\Query\InstitutionQuery())
    ->setInclude([\Nordkirche\Ndk\Domain\Model\Institution\Institution::RELATION_ADDRESS]);

$result = $repository->get($query);

echo PHP_EOL . "- - - - - - - with address relations included - - - - - - -" . PHP_EOL;

/** @var \Nordkirche\Ndk\Domain\Model\Institution\Institution $institution */
foreach ($result as $institution) {
    echo $institution->getAddress()->getZipCode() . PHP_EOL;
}