<?php

namespace Nordkirche\Ndk\Domain\Repository;

use Nordkirche\Ndk\Domain\Model\Institution\Institution;
use Nordkirche\Ndk\Domain\Model\Offertory\Offertory;
use Nordkirche\Ndk\Domain\Query\PageQuery;
use Nordkirche\Ndk\Helper\SetupApiTrait;
use Nordkirche\Ndk\Service\Result;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{

    use SetupApiTrait;

    /**
     * @var array
     */
    protected $fixture;

    public function setUp()
    {
        parent::setUp();

        $api = $this->createApiInstance();

        $this->fixture = [
            [
                $api->factory(EventRepository::class),
                \Nordkirche\Ndk\Domain\Model\Event\Event::class
            ],
            [
                $api->factory(PersonRepository::class),
                \Nordkirche\Ndk\Domain\Model\Person\Person::class
            ],
            [
                $api->factory(AddressRepository::class),
                \Nordkirche\Ndk\Domain\Model\Address::class
            ],
            [
                $api->factory(InstitutionRepository::class),
                Institution::class
            ],
            [
            $api->factory(OffertoryRepository::class),
                Offertory::class
            ]
        ];
    }

    /**
     * @group e2e
     */
    public function testGetAll()
    {
        foreach ($this->fixture as $item) {
            /** @var $repository \Nordkirche\Ndk\Domain\Interfaces\RepositoryInterface */
            /** @var $modelClass string */
            list($repository, $modelClass) = $item;
            $collection = $repository->get();

            self::assertTrue($collection instanceof Result, 'Must return a Result object');
            self::assertTrue($collection->count() > 0, 'Result object should have more than 0 objects');
            self::assertTrue($collection->current() instanceof $modelClass,
                'Objects should be of type ' . $modelClass);
            self::assertTrue($collection->getRecordCount() > 1, 'Record count is wrong');
            self::assertTrue($collection->getPageCount() > 1, 'Current page count is wrong');
        }
    }

    public function paginationProvider()
    {
        return [
            [1, 5],
            [2, 5],
            [1, 10]
        ];
    }

    /**
     * @param int $page
     * @param int $size
     *
     * @group e2e
     * @dataProvider paginationProvider
     */
    public function testPagination($page, $size)
    {
        foreach ($this->fixture as $item) {
            /** @var $repository \Nordkirche\Ndk\Domain\Interfaces\RepositoryInterface */
            /** @var $modelClass string */
            list($repository, $modelClass) = $item;
            $collection = $repository->get(new PageQuery($page, $size));

            self::assertTrue($collection instanceof Result, 'Must return a Result object');
            self::assertTrue($collection->count() == $size, 'Result object should have ' . $size . ' objects');
            self::assertTrue($collection->current() instanceof $modelClass, 'Objects should be of type ' . $modelClass);
        }
    }
}
