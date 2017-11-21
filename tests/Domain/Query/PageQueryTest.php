<?php

namespace Nordkirche\Ndk\Domain\Query;

use PHPUnit\Framework\TestCase;

class MockPageQuery extends PageQuery
{

    public $testProperty;
}

class PageQueryTest extends TestCase
{

    public function subjectProvider()
    {
        return [
            [new PageQuery()]
        ];
    }

    /**
     * @group unit
     */
    public function testPropertyCamelCaseToSnakeCase()
    {
        $testSubject = new PageQuery();
        $testSubject->setFilterProperties(['testProperty']);
        $testSubject->testProperty = 'foobar';
        self::assertArrayHasKey('filter', $testSubject->returnUrlParameters());
        self::assertArrayHasKey('test_property', $testSubject->returnUrlParameters()['filter']);
    }

    /**
     * @group unit
     */
    public function testReturnUrlParametersNotSet()
    {
        $testSubject = new PageQuery();
        $testSubject->testProperty = 'This is söme Extreme <br /> value for ? \' Filter';

        self::assertArrayNotHasKey('filter', $testSubject->returnUrlParameters());
        self::assertArrayHasKey('page', $testSubject->returnUrlParameters());
    }

    /**
     * @param PageQuery $testSubject
     *
     * @dataProvider subjectProvider
     * @group unit
     */
    public function testWithAdditionalProperty(PageQuery $testSubject)
    {
        $testSubject->setFilterProperties(['testProperty']);
        $testSubject->testProperty = 'This is söme Extreme <br /> value for ? \' Filter';
        self::assertEquals('?filter%5Btest_property%5D=This+is+s%C3%B6me+Extreme+%3Cbr+%2F%3E+value+for+%3F+%27+Filter&page%5Bnumber%5D=1&page%5Bsize%5D=10',
            $testSubject->__toString());
    }

    /**
     * @param PageQuery $testSubject
     *
     * @dataProvider subjectProvider
     * @group unit
     */
    public function testDefaultPageSettings(PageQuery $testSubject)
    {
        self::assertEquals('?page%5Bnumber%5D=1&page%5Bsize%5D=10', $testSubject->__toString());
    }

    /**
     * @param PageQuery $testSubject
     *
     * @dataProvider subjectProvider
     * @group unit
     */
    public function testPageNumberPageSize(PageQuery $testSubject)
    {
        $testSubject->setPageNumber(777);
        $testSubject->setPageSize(12);

        self::assertEquals('?page%5Bnumber%5D=777&page%5Bsize%5D=12', $testSubject->__toString());
    }

    /**
     * @group unit
     */
    public function testSortAscending()
    {
        $testSubject = new PageQuery();
        $testSubject->setSort('some_field', PageQuery::SORT_ASC);

        self::assertEquals('?page%5Bnumber%5D=1&page%5Bsize%5D=10&sort=some_field', $testSubject->__toString());
    }

    /**
     * @group unit
     */
    public function testSortDecending()
    {
        $testSubject = new PageQuery();
        $testSubject->setSort('some_field', PageQuery::SORT_DESC);

        self::assertEquals('?page%5Bnumber%5D=1&page%5Bsize%5D=10&sort=-some_field', $testSubject->__toString());
    }
}