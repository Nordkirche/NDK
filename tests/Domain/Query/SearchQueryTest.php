<?php

namespace Nordkirche\Ndk\Domain\Query;

use PHPUnit\Framework\TestCase;

class SearchQueryTest extends TestCase
{

    /**
     * @group unit
     */
    public function testSetQuery()
    {
        $query = new SearchQuery();
        $query->setQuery('String');

        self::assertContains(
            '/string',
            (string)$query
        );

        return $query;
    }

    /**
     * @group unit
     */
    public function testQueryWithBlank()
    {
        $query = new SearchQuery();
        $query->setQuery('Vorname Name');

        self::assertContains(
            '/vorname%20name',
            (string)$query
        );

        return $query;
    }

    /**
     * @group unit
     */
    public function testSetFieldsInstitutions()
    {
        $query = new SearchQuery();
        $query->setQuery('String')->setFieldsInstitutions(['abc', 'def']);

        self::assertEquals(
            '/string?page%5Bnumber%5D=1&page%5Bsize%5D=10&fields%5Binstitutions%5D=abc%2Cdef',
            (string)$query
        );
    }

    /**
     * @group unit
     */
    public function testSetFieldsPeople()
    {
        $query = new SearchQuery();
        $query->setQuery('String')->setFieldsPeople(['abc', 'def']);

        self::assertEquals(
            '/string?page%5Bnumber%5D=1&page%5Bsize%5D=10&fields%5Bpeople%5D=abc%2Cdef',
            (string)$query
        );
    }
}

