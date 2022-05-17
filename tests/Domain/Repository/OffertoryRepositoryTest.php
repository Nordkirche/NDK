<?php

namespace Nordkirche\Ndk\Domain\Repository;

use Nordkirche\Ndk\Domain\Model\Offertory\Offertory;
use Nordkirche\Ndk\Domain\Query\OffertoryQuery;
use Nordkirche\Ndk\Service\Result;

class OffertoryRepositoryTest extends \Nordkirche\Ndk\Helper\AbstractE2eTestCase
{

    /**
     * @var OffertoryRepository
     */
    private $testSubject;

    public function setUp(): void
    {
        parent::setUp();
        $this->testSubject = $this->api->factory(OffertoryRepository::class);
    }

    /**
     * @group e2e
     */
    public function testGetSingle()
    {
        /** @var Offertory $offertory */
        $offertory = $this->testSubject->getById(1);

        self::assertTrue($offertory instanceof Offertory);

    }

    /**
     * @group e2e
     */
    public function testQueryCategories()
    {
        $query = new OffertoryQuery();
        $query->setCategories([564]); // 564 = Mitverantwortung
        $collection = $this->testSubject->get($query);
        self::assertCollectionOfOffertories($collection);
    }

    /**
     * @param $collection Result
     */
    static protected function assertCollectionOfOffertories($collection)
    {
        self::assertCollectionOf($collection, Offertory::class);
    }

    /**
     * @param $collection Result
     * @param $objectType string
     */
    static protected function assertCollectionOf($collection, $objectType)
    {
        self::assertTrue($collection instanceof Result, 'Must return a Result object');
        self::assertTrue($collection->count() > 0, 'Result object should have some objects');
        self::assertInstanceOf($objectType, $collection->current(), 'Objects should be of type '.$objectType);
    }

}