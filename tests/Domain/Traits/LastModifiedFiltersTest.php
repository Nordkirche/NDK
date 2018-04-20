<?php

namespace Nordkirche\Ndk\Domain\Traits;

use Nordkirche\Ndk\Domain\Query\AbstractQuery;
use PHPUnit\Framework\TestCase;

class MockQuery extends AbstractQuery
{
    use LastModifiedFilters;
}

class LastModifiedFiltersTest extends TestCase
{
    /**
     * @group unit
     */
    public function testModifiedBefore()
    {
        $dateTime = new \DateTime('2017-02-21T15:17:47+0000');
        $testSubject = new MockQuery();
        $testSubject->setModifiedBefore($dateTime);

        self::assertEquals(
            '?filter%5Bmodified_before%5D=2017-02-21T15%3A17%3A47%2B0000',
            $testSubject->__toString()
        );
    }

    /**
     * @group unit
     */
    public function testModifiedAfter()
    {
        $dateTime = new \DateTime('2017-02-21T15:17:47+0000');
        $testSubject = new MockQuery();
        $testSubject->setModifiedAfter($dateTime);

        self::assertEquals(
            '?filter%5Bmodified_after%5D=2017-02-21T15%3A17%3A47%2B0000',
            $testSubject->__toString()
        );
    }

    /**
     * @group unit
     */
    public function testBothFiltersTogether() {
        $testSubject = new MockQuery();
        $testSubject->setModifiedBefore(new \DateTime('2017-02-21T15:17:47+0000'));
        $testSubject->setModifiedAfter(new \DateTime('2016-01-21T19:17:00+0000'));

        self::assertEquals(
            '?filter%5Bmodified_before%5D=2017-02-21T15%3A17%3A47%2B0000&filter%5Bmodified_after%5D=2016-01-21T19%3A17%3A00%2B0000',
            $testSubject->__toString()
        );
    }
}
