<?php

namespace Nordkirche\Ndk\Service;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $responseMock;

    private $testMetaData = [
        'some' => 'interesting',
        'meta' => 'data'
    ];

    private $testDataData = [
        'super' => 'interesting',
        'data' => 'in an array'
    ];

    private $testLinksData = [
        'these are' => 'links from',
        'for usage' => 'anywhere you\'d like'
    ];

    private $testIncludedData = [
        [
            'id' => 1,
            'type' => 'mockmodeltype',
            'attributes' => [
                'number' => 1234,
                'float' => 56.78,
                'string' => 'Lorem Ipsum Si Solor',
                'boolean' => true
            ]
        ]
    ];

    private $testFacetsData = [
        'meta' => [
            'facets' => [
                'foo' => [1,2,3,4,5],
                'bar'=> [6,7,8,8,10]
            ]
        ]
    ];

    public function setUp():void
    {
        /** @var \Psr\Http\Message\ResponseInterface $responseMock */
        $this->responseMock = $this->createMock(\Psr\Http\Message\ResponseInterface::class);
    }

    /**
     * @group unit
     */
    public function testConstructor()
    {
        $testSubject = new Response(
            $this->responseMock,
            [
                'data' => $this->testDataData,
                'meta' => $this->testMetaData,
                'links' => $this->testLinksData,
                'included' => $this->testIncludedData
            ]
        );

        TestCase::assertEquals($testSubject->getRawData(), $this->testDataData, 'Check if data equals the expected values');
        TestCase::assertEquals($testSubject->getLinks(), $this->testLinksData, 'Check if data equals the expected values');
        TestCase::assertEquals($testSubject->getMeta(), $this->testMetaData, 'Check if data equals the expected values');
        TestCase::assertEquals($testSubject->getIncluded(), $this->testIncludedData, 'Check if data equals the expected values');
    }

    /**
     * @group unit
     */
    public function testFacets()
    {
        $testSubject = new Response(
            $this->responseMock,
            $this->testFacetsData
        );

        $facets = $testSubject->getMeta('facets');

        self::assertCount(2, $facets);
        self::assertArrayHasKey('foo', $facets);
        self::assertArrayHasKey('bar', $facets);
        self::assertEquals($facets['foo'],$this->testFacetsData['meta']['facets']['foo']);
        self::assertEquals($facets['bar'],$this->testFacetsData['meta']['facets']['bar']);
    }
}
