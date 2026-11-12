<?php

namespace Nordkirche\Ndk\Domain\Query;

use PHPUnit\Framework\TestCase;

class EventQueryTest extends TestCase
{

    /**
     * @group unit
     */
    public function testSetEventTypeIsReturnedByGetter()
    {
        $query = new EventQuery();
        $query->setEventType('Gottesdienst');

        self::assertSame('Gottesdienst', $query->getEventType());
        self::assertSame(['Gottesdienst'], $query->getEventTypes());
    }

    /**
     * @group unit
     */
    public function testGetEventTypeWithoutValue()
    {
        self::assertSame('', (new EventQuery())->getEventType());
    }

    /**
     * @group unit
     */
    public function testSetEventTypesCreatesCommaSeparatedFilter()
    {
        $query = new EventQuery();
        $query->setEventTypes(['Gottesdienst', 'Konzert']);

        self::assertSame('Gottesdienst', $query->getEventType());
        self::assertStringContainsString(
            'filter%5Bevent_type%5D=Gottesdienst%2CKonzert',
            (string)$query
        );
    }
}
