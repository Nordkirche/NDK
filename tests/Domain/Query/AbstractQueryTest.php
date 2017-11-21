<?php

namespace Nordkirche\Ndk\Domain\Query;

use PHPUnit\Framework\TestCase;

class MockQuery extends AbstractQuery
{

    public $testProperty;
}

class MockQueryParameterValue implements \Nordkirche\Ndk\Domain\Interfaces\QueryParameterValue
{

    public function returnParameterValue(): string
    {
        return __CLASS__;
    }
}

class AbstractQueryTest extends TestCase
{

    public function subjectProvider()
    {
        return [
            [new MockQuery()]
        ];
    }

    public function specialValueProvider()
    {
        return [
            [false, 'False should not be seen as empty'],
            [0, '0 should not be seend as empty'],
            [0.00, '0.00 should not be seen as empty']
        ];
    }

    public function emptyValueProvider()
    {
        return [
            [null, 'null should be seen as empty'],
            ['', '"" should be seen as empty'],
            ['  ', '"  " should be seen as empty']
        ];
    }

    public function resourceUrlProvider()
    {
        return [
            ['napi://resource/people/1', '?filter%5Btest_property%5D=1'],
            [
                [
                    'napi://resource/people/1',
                    'napi://resource/people/2',
                    'napi://resource/people/3',
                ],
                '?filter%5Btest_property%5D=1%2C2%2C3'
            ],
            [
                [
                    'napi://resource/people/1',
                    2,
                    'napi://resource/people/3',
                ],
                '?filter%5Btest_property%5D=1%2C2%2C3'
            ]
        ];
    }

    /**
     * @group unit
     */
    public function testPropertyCamelCaseToSnakeCase()
    {
        $testSubject = new MockQuery();
        $testSubject->setFilterProperties(['testProperty']);
        $testSubject->testProperty = 'foobar';
        self::assertArrayHasKey('filter', $testSubject->returnUrlParameters());
        self::assertArrayHasKey('test_property', $testSubject->returnUrlParameters()['filter']);
    }

    /**
     * @group unit
     */
    public function testFilterPropertiesNotSet()
    {
        $testSubject = new MockQuery();
        $testSubject->testProperty = 'This is söme Extreme <br /> value for ? \' Filter';

        self::assertArrayNotHasKey('filter', $testSubject->returnUrlParameters());
    }

    /**
     * @group unit
     */
    public function testFilterPropertyEmpty()
    {
        $testSubject = new MockQuery();
        $testSubject->setFilterProperties(['testProperty']);

        self::assertArrayNotHasKey('filter', $testSubject->returnUrlParameters());
    }

    /**
     * @param $value
     * @param $message
     *
     * @dataProvider specialValueProvider
     * @group unit
     */
    public function testReturnUrlParametersSpecialValue($value, $message)
    {
        $testSubject = new MockQuery();
        $testSubject->setFilterProperties(['testProperty']);
        $testSubject->testProperty = $value;
        self::assertArrayHasKey('filter', $testSubject->returnUrlParameters(), $message);
    }

    /**
     * @param $value
     * @param $message
     *
     * @dataProvider emptyValueProvider
     * @group unit
     */
    public function testReturnUrlParametersEmptyProperty($value, $message)
    {
        $testSubject = new MockQuery();
        $testSubject->setFilterProperties(['testProperty']);
        $testSubject->testProperty = $value;
        self::assertArrayNotHasKey('filter', $testSubject->returnUrlParameters(), $message);
    }

    /**
     * @param MockQuery $testSubject
     *
     * @dataProvider subjectProvider
     * @group unit
     */
    public function testReturnUrlParameters(MockQuery $testSubject)
    {
        $testSubject->setFilterProperties(['testProperty']);
        $testSubject->testProperty = 'This is söme Extreme <br /> value for ? \' Filter';

        $urlParameters = $testSubject->returnUrlParameters();

        self::assertArrayHasKey('filter', $urlParameters);
        self::assertArrayHasKey('test_property', $urlParameters['filter'], print_r($urlParameters, true));
        self::assertEquals(
            ['filter' => ['test_property' => $testSubject->testProperty]],
            $testSubject->returnUrlParameters()
        );
    }

    /**
     * @param MockQuery $testSubject
     *
     * @dataProvider subjectProvider
     * @group unit
     */
    public function testToString(MockQuery $testSubject)
    {
        $testSubject->setFilterProperties(['testProperty']);
        $testSubject->testProperty = 'This is söme Extreme <br /> value for ? \' Filter';
        self::assertEquals('?filter%5Btest_property%5D=This+is+s%C3%B6me+Extreme+%3Cbr+%2F%3E+value+for+%3F+%27+Filter',
            $testSubject->__toString());
    }

    /**
     * @param MockQuery $testSubject
     *
     * @dataProvider subjectProvider
     * @group unit
     */
    public function testToStringWithoutProperty(MockQuery $testSubject)
    {
        self::assertEquals('', $testSubject->__toString());
    }

    /**
     * @group unit
     */
    public function testDateTimeTransformation()
    {
        $testSubject = new MockQuery();
        $testSubject->setFilterProperties(['testProperty']);
        $testSubject->testProperty = new \DateTime('1.1.2016');
        self::assertEquals(
            '?filter%5Btest_property%5D=2016-01-01T00%3A00%3A00%2B0000',
            $testSubject->__toString()
        );
    }

    /**
     * @param $propertyValue
     * @param $expected
     *
     * @group unit
     * @dataProvider resourceUrlProvider
     */
    public function testNapiResourceUrlTransformation($propertyValue, $expected)
    {
        $testSubject = new MockQuery();
        $testSubject->setFilterProperties(['testProperty']);
        $testSubject->testProperty = $propertyValue;

        self::assertEquals(
            $expected,
            $testSubject->__toString(),
            print_r($propertyValue, true)
        );
    }

    /**
     * @group unit
     */
    public function testSetInclude()
    {
        $testSubject = new MockQuery();
        $testSubject->setInclude([
            'some',
            'foo_bar',
            'strings'
        ]);
        self::assertEquals(
            '?include=some%2Cfoo_bar%2Cstrings',
            $testSubject->__toString()
        );
    }

    /**
     * @group unit
     */
    public function testSetIncludeWithArray()
    {
        $testSubject = new MockQuery();
        $testSubject->setInclude([
            'anything' => ['property'],
            'foo_bar' => ['this', 'that']
        ]);
        self::assertEquals(
            '?include=anything.property%2Cfoo_bar.this%2Cfoo_bar.that',
            $testSubject->__toString()
        );
    }

    /**
     * @group unit
     */
    public function testSetIncludeWithBoth()
    {
        $testSubject = new MockQuery();
        $testSubject->setInclude([
            'some',
            'anything' => ['property'],
            'foo_bar' => ['this', 'that'],
            'string'
        ]);
        self::assertEquals(
            '?include=some%2Canything.property%2Cfoo_bar.this%2Cfoo_bar.that%2Cstring',
            $testSubject->__toString()
        );
    }

    /**
     * @group unit
     */
    public function testUseQueryParameterValueObject()
    {
        $testSubject = new MockQuery();
        $testSubject->setFilterProperties(['testProperty']);
        $testSubject->testProperty = new MockQueryParameterValue();
        self::assertEquals(
            MockQueryParameterValue::class,
            $testSubject->returnUrlParameters()['filter']['test_property'],
            'QueryParameterValue Objects are not resolved to a string for usage'
        );
    }
}