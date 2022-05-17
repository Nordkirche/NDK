<?php

namespace Nordkirche\Ndk\Domain\Query;

use PHPUnit\Framework\TestCase;

class SuggestQueryTest extends TestCase
{

    /**
     * @group unit
     */
    public function testSetQuery()
    {
        $query = new SuggestQuery();
        $query->setQuery('String');

        self::assertStringContainsString(
            '/String',
            (string)$query
        );

        return $query;
    }

    /**
     * @group unit
     */
    public function testQueryWithBlank()
    {
        $query = new SuggestQuery();
        $query->setQuery('Vorname Name');

        self::assertStringContainsString(
            '/Vorname%20Name',
            (string)$query
        );

        return $query;
    }

}

