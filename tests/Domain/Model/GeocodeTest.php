<?php

namespace Nordkirche\Ndk\Domain\Model;

class GeocodeTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @group unit
     */
    public function testConstructor()
    {
        $subject = new Geocode(12.34, 56.78, 1011);

        self::assertEquals(12.34, $subject->getLatitude());
        self::assertEquals(56.78, $subject->getLongitude());
        self::assertEquals(1011, $subject->getRadius());
    }

    /**
     * @group unit
     */
    public function testConstructorWithMissingRadius()
    {
        $subject = new Geocode(12.34, 56.78);
        self::assertEquals(0, $subject->getRadius());
    }
}
