<?php

namespace Nordkirche\Ndk\Domain\Repository;

use Nordkirche\Ndk\Domain\Model\Institution\Institution;
use Nordkirche\Ndk\Domain\Query\InstitutionQuery;
use Nordkirche\Ndk\Service\Result;

class InstitutionRepositoryTest extends \Nordkirche\Ndk\Helper\AbstractE2eTestCase
{

    /**
     * @var InstitutionRepository
     */
    private $testSubject;

    public function setUp()
    {
        parent::setUp();
        $this->testSubject = $this->api->factory(InstitutionRepository::class);
    }

    /**
     * @group e2e
     */
    public function testGetSingle()
    {
        /** @var Institution $institution */
        $institution = $this->testSubject->getById(1930);

        self::assertTrue($institution instanceof Institution);

        // all these testes are made under the assumpation that the institution AfÖ (1930) has those relation
        self::assertInstanceOf(\Nordkirche\Ndk\Domain\Model\Address::class, $institution->getAddress());
    }

    /**
     * @group e2e
     */
    public function testQueryAncestorInstitution()
    {
        $query = new InstitutionQuery();
        $query->setAncestorInstitutions([2658]); // 2658 = Kirchenkreis Schleswig-Flensburg
        $collection = $this->testSubject->get($query);
        self::assertCollectionOfInstitutions($collection);
    }

    /**
     * @param $collection Result
     */
    static protected function assertCollectionOfInstitutions($collection)
    {
        self::assertCollectionOf($collection, Institution::class);
    }

    /**
     * @group e2e
     */
    public function testQueryParentInstitution()
    {
        $query = new InstitutionQuery();
        $query->setParentInstitutions([2658]); // 2658 = Kirchenkreis Schleswig-Flensburg
        $collection = $this->testSubject->get($query);
        self::assertCollectionOfInstitutions($collection);
    }

    /**
     * @group e2e
     */
    public function testQueryInstitutionType()
    {
        $query = new InstitutionQuery();
        $query->setInstitutionType([12]); // 12 = Kirchenkreis
        $collection = $this->testSubject->get($query);
        self::assertCollectionOfInstitutions($collection);
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
