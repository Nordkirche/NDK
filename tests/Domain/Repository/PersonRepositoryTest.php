<?php

namespace Nordkirche\Ndk\Domain\Repository;

use Nordkirche\Ndk\Domain\Model\Person\Person;
use Nordkirche\Ndk\Domain\Model\Person\PersonFunction;

class PersonRepositoryTest extends \Nordkirche\Ndk\Helper\AbstractE2eTestCase
{

    /**
     * @var PersonRepository
     */
    protected $testSubject;

    public function setUp()
    {
        parent::setUp();
        $this->testSubject = $this->api->factory(PersonRepository::class);
    }

    /**
     * @group e2e
     */
    public function testGetSingle()
    {
        /** @var \Nordkirche\Ndk\Domain\Model\Person\Person $person */
        $person = $this->testSubject->getById(2);
        self::assertTrue($person instanceof \Nordkirche\Ndk\Domain\Model\Person\Person);
    }

    /**
     * We have to check if Persons can be decorated with functions (aka roles). We cannot use "function" as a name for
     * objects. So we create the according object "PersonFunction" and rely on auto-mapping of the
     * ModelDecoratorService to take "functions" use "PersonFunction" as the subtype of a \SplObjectStorage and
     * decorate the object correctly.
     *
     * @group e2e
     */
    public function testDecorateWithFunctions()
    {
        /** @var \Nordkirche\Ndk\Domain\Model\Person\Person $person */
        $person = $this->testSubject->getById(1138);
        self::assertContainsOnlyInstancesOf(
            \Nordkirche\Ndk\Domain\Model\Person\PersonFunction::class,
            $person->getFunctions()
        );
    }
}
