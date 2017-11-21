<?php

namespace Nordkirche\Ndk\Service;

use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{

    /**
     * @var \SplObjectStorage
     */
    private $fixture;

    public function setUp()
    {
        $objectStorage = new \SplObjectStorage();
        $objectStorage->attach(new MockModel());
        $objectStorage->attach(new MockModel());
        $objectStorage->attach(new MockModel());

        $this->fixture = new \Nordkirche\Ndk\Service\Result($objectStorage, 1, 3);
    }

    /**
     * @group unit
     */
    public function testCountable()
    {
        self::assertEquals($this->fixture->count(), 3);
        self::assertEquals(count($this->fixture),3);
    }

    /**
     * @group unit
     */
    public function testIteratable()
    {
        foreach($this->fixture as $object) {
            self::assertTrue(isset($object));
            self::assertTrue($object instanceof MockModel);
        }
    }
}
