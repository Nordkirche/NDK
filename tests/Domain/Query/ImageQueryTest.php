<?php

namespace Nordkirche\Ndk\Domain\Query;

use PHPUnit\Framework\TestCase;

class ImageQueryTest extends TestCase
{

    /**
     * @group unit
     */
    public function testQuery()
    {
        $query = new ImageQuery();
        $query->setId(1235);

        self::assertEquals(
            '/1235',
            (string)$query
        );
    }

    /**
     * @group unit
     */
    public function testSetWidth()
    {
        $query = new ImageQuery();
        $query->setId(1235)->setWidth('100c');

        self::assertEquals(
            '/1235?w=100c',
            (string)$query
        );
    }

    /**
     * @group unit
     */
    public function testSetHeight()
    {
        $query = new ImageQuery();
        $query->setId(1235)->setHeight('100c');

        self::assertEquals(
            '/1235?h=100c',
            (string)$query
        );
    }

    /**
     * @group unit
     */
    public function testSetWidthAndHeight()
    {
        $query = new ImageQuery();
        $query->setId(1235)->setHeight('66c')->setWidth('33c');

        self::assertEquals(
            '/1235?w=33c&h=66c',
            (string)$query
        );
    }

    /**
     * @group unit
     */
    public function testConstructorWithUrl()
    {
        $testId = 12345;
        $testUrl = '/api/v1/images/' . $testId;
        $query = new ImageQuery($testUrl);

        self::assertEquals($testId, $query->getId());
    }

    /**
     * @group unit
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 1502130522
     */
    public function testConstructorWithUrlFails()
    {
        $this->expectException(\InvalidArgumentException::class);

        $testUrl = '/some/random/url/with/integer/123';
        new ImageQuery($testUrl);
    }
}
