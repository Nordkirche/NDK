<?php

namespace Nordkirche\Ndk\Service;

use Monolog\Logger;
use Nordkirche\Ndk\Helper\AbstractIntegrationTestCase;
use Nordkirche\Ndk\Helper\MockModel;
use Nordkirche\Ndk\Helper\MockSiblingModel;

class ResolutionServiceTest extends AbstractIntegrationTestCase
{

    /**
     * @var ResolutionService
     */
    private $resolutionService;

    private $singelPrimaryData = [
        'id' => 1,
        'type' => 'mock-model-type',
        'attributes' => [
            'integer' => 1234,
            'string' => 'Some nice string for you.'
        ]
    ];

    private $searchData = [
        'data' => [
            [
                'id' => 1,
                'type' => 'mock-model-type',
                'attributes' => [
                    'integer' => 1234,
                    'string' => 'Some nice string for you.'
                ],
                'meta' => [
                    'score' => 9.793051
                ]
            ]
        ],
        'meta' => [
            'page_count' => 1,
            'record_count' => 1
        ]
    ];

    private $includedData = [
        [
            'id' => 1,
            'type' => 'mock-model-type',
            'attributes' => [
                'integer' => 1234,
                'string' => 'Some nice string for you.'
            ]
        ],
        [
            'id' => 2,
            'type' => 'mock-model-type',
            'attributes' => [
                'integer' => 4567,
                'string' => 'Other strings are fine too.'
            ]
        ]
    ];

    private $resolveIncludeData = [
        'data' => [
            'id' => '1',
            'type' => 'mock-model-type',
            'attributes' => [
                'integer' => 1234,
                'string' => 'Some nice string for you.'
            ],
            'relationships' => [
                'object' => [
                    'links' => [],
                    'data' => [
                        'id' => '2',
                        'type' => 'mock-model-sibling-type',
                    ]
                ]
            ]
        ],
        'included' => [
            [
                'id' => '2',
                'type' => 'mock-model-sibling-type',
                'attributes' => [
                    'integer' => '1234',
                    'string' => 'Some nice string for you.'
                ]
            ]
        ],
        'meta' => [
            'page_count' => 1,
            'record_count' => 1
        ]
    ];

    private $skipRelationshipWhenIncludeIsMissing = [
        'data' => [
            'id' => '1',
            'type' => 'mock-model-type',
            'attributes' => [
                'integer' => 1234,
                'string' => 'Some nice string for you.'
            ],
            'relationships' => [
                'object' => [
                    'links' => [],
                    'data' => [
                        'id' => '2',
                        'type' => 'mock-model-sibling-type',
                    ]
                ]
            ]
        ],
        'included' => [
        ],
        'meta' => [
            'page_count' => 1,
            'record_count' => 1
        ]
    ];

    private $resolveIncludeDataMultipleRelations = [
        'data' => [
            'id' => '1',
            'type' => 'mock-model-type',
            'attributes' => [
                'integer' => 1234,
                'string' => 'Some nice string for you.'
            ],
            'relationships' => [
                'resultObject' => [
                    'links' => [],
                    'data' => [
                        [
                            'id' => '2',
                            'type' => 'mock-model-sibling-type',
                        ],
                        [
                            'id' => '3',
                            'type' => 'mock-model-sibling-type',
                        ]
                    ]
                ]
            ]
        ],
        'included' => [
            [
                'id' => '2',
                'type' => 'mock-model-sibling-type',
                'attributes' => [
                    'integer' => '1234',
                    'string' => 'Some nice string for you.'
                ]
            ],
            [
                'id' => '3',
                'type' => 'mock-model-sibling-type',
                'attributes' => [
                    'integer' => '1234',
                    'string' => 'Some nice string for you.'
                ]
            ]
        ],
        'meta' => [
            'page_count' => 1,
            'record_count' => 1
        ]
    ];

    private $skipSubRelationshipsWhenIncludeIsMissing = [
        'data' => [
            'id' => '1',
            'type' => 'mock-model-type',
            'attributes' => [
                'integer' => 1234,
                'string' => 'Some nice string for you.'
            ],
            'relationships' => [
                'resultObject' => [
                    'links' => [],
                    'data' => [
                        [
                            'id' => '2',
                            'type' => 'mock-model-sibling-type',
                        ],
                        [
                            'id' => '3',
                            'type' => 'mock-model-sibling-type',
                        ],
                        [
                            'id' => '4',
                            'type' => 'mock-model-sibling-type',
                        ]
                    ]
                ]
            ]
        ],
        'included' => [
            [
                'id' => '2',
                'type' => 'mock-model-sibling-type',
                'attributes' => [
                    'integer' => '1234',
                    'string' => 'Some nice string for you.'
                ]
            ],
            [
                'id' => '4',
                'type' => 'mock-model-sibling-type',
                'attributes' => [
                    'integer' => '1234',
                    'string' => 'Some nice string for you.'
                ]
            ]
        ],
        'meta' => [
            'page_count' => 1,
            'record_count' => 1
        ]
    ];

    private $resolveSubIncludeData = [
        'data' => [
            'id' => '1',
            'type' => 'mock-model-type',
            'attributes' => [
                'integer' => 1234,
                'string' => 'Some nice string for you.'
            ],
            'relationships' => [
                'object' => [
                    'links' => [],
                    'data' => [
                        'id' => '2',
                        'type' => 'mock-model-sibling-type',
                    ]
                ]
            ]
        ],
        'included' => [
            [
                'id' => '2',
                'type' => 'mock-model-sibling-type',
                'attributes' => [
                    'integer' => 1234,
                    'string' => 'Some nice string for you.'
                ],
                'relationships' => [
                    'object' => [
                        'links' => [],
                        'data' => [
                            'id' => '3',
                            'type' => 'mock-model-sibling-type',
                        ]
                    ]
                ]
            ],
            [
                'id' => '3',
                'type' => 'mock-model-sibling-type',
                'attributes' => [
                    'integer' => 4567,
                    'string' => 'Other strings are fine too.'
                ]
            ],
        ],
        'meta' => [
            'page_count' => 1,
            'record_count' => 1
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->api->getConfiguration()->setTypeClassMap([
            'mock-model-type' => \Nordkirche\Ndk\Helper\MockModel::class,
            'mock-model-sibling-type' => \Nordkirche\Ndk\Helper\MockSiblingModel::class
        ]);
        $this->resolutionService = $this->api->factory(ResolutionService::class);
    }

    /**
     * @group integration
     */
    public function testResolveIncludes()
    {
        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                [
                    'included' => $this->includedData,
                    'meta' => [
                        'page_count' => 1,
                        'record_count' => count($this->includedData)
                    ]
                ]
            )
        );

        /** @var MockModel $object */
        for ($i = 0; $i < 2; $i++) {

            $object = $this->resolutionService->get('mock-model-type', $this->includedData[$i]['id']);

            self::assertTrue($object instanceof MockModel, 'Wrong object was created');
            self::assertEquals($object->getId(), $this->includedData[$i]['id'], 'Wrong value');
            self::assertEquals($object->getType(), $this->includedData[$i]['type'], 'Wrong value');
            self::assertEquals($object->getInteger(), $this->includedData[$i]['attributes']['integer'], 'Wrong value');
            self::assertEquals($object->getString(), $this->includedData[$i]['attributes']['string'], 'Wrong value');
        }
    }

    /**
     * @group integration
     */
    public function testResolveSearchMetaData()
    {
        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                $this->searchData
            )
        );

        /** @var MockModel $object */
        $object = $this->resolutionService->get('mock-model-type', 1);

        self::assertTrue($object instanceof MockModel, 'Wrong object was created');

        self::assertInstanceOf(\Nordkirche\Ndk\Domain\Model\MetaData::class, $object->getMetaData());
        self::assertEquals($this->searchData['data'][0]['meta']['score'], $object->getMetaData()->getScore());
    }

    /**
     * @group integration
     */
    public function testResolveAndDecorateMultipleRelations()
    {
        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                $this->resolveIncludeDataMultipleRelations
            )
        );

        /** @var MockModel $object */
        $object = $this->resolutionService->get('mock-model-type', 1);

        self::assertInstanceOf(MockModel::class, $object, 'Wrong object was created');
        self::assertInstanceOf(Result::class, $object->getResultObject(), 'Result object is missing.');
        self::assertInstanceOf(MockSiblingModel::class, $object->getResultObject()->current(),
            'Child object is missing.');
    }

    /**
     * @group integration
     */
    public function testResolveAndDecorateIncludes()
    {
        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                $this->resolveIncludeData
            )
        );

        /** @var MockModel $object */
        $object = $this->resolutionService->get('mock-model-type', 1);

        self::assertInstanceOf(MockModel::class, $object, 'Wrong object was created');
        self::assertInstanceOf(MockSiblingModel::class, $object->getObjectRaw(), 'Wrong subobject 1st level was created.');
    }

    /**
     * @group integration
     */
    public function testReturnResolutionProxyWhenIncludeIsMissing()
    {
        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                $this->skipRelationshipWhenIncludeIsMissing
            )
        );

        /** @var MockModel $object */
        $object = $this->resolutionService->get('mock-model-type', 1);

        self::assertInstanceOf(MockModel::class, $object, 'Wrong object was created');
        self::assertInstanceOf(ResolutionProxy::class, $object->getObjectRaw(), 'Wrong subobject 1st level was created.');
    }

    /**
     * @group integration
     */
    public function testSkipRelationShipWhenIncludeIsMissing()
    {
        $this->api->getConfiguration()->setResolutionProxyDisabled(true);

        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                $this->skipRelationshipWhenIncludeIsMissing
            )
        );

        /** @var MockModel $object */
        $object = $this->resolutionService->get('mock-model-type', 1);

        self::assertInstanceOf(MockModel::class, $object, 'Wrong object was created');
        self::assertInstanceOf(MissingResourceProxy::class, $object->getObjectRaw(), 'Wrong object was created');
        self::assertNull($object->getObject());
    }

    /**
     * @group integration
     */
    public function testLogSkipRelationshipWhenIncludeIsMissing()
    {
        $this->api->getConfiguration()->setResolutionProxyDisabled(true);

        $handler = $this->setUpLogger();

        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                $this->skipRelationshipWhenIncludeIsMissing
            )
        );

        /** @var MockModel $mockModel */
        $mockModel = $this->resolutionService->get('mock-model-type', 1);

        $object = $mockModel->getObjectRaw();

        self::assertInstanceOf(MissingResourceProxy::class, $object);

        $mockModel->getObject(); // this should trigger a log entry

        $log = $handler->close();

        self::assertNotEmpty($log);
        self::assertCount(1, $log);

        $logEntry = $log[0];
        self::assertArrayHasKey('message', $logEntry);
        self::assertEquals($logEntry['message'], 'Skipped relationship because it was not found in includes');

        self::assertArrayHasKey('context', $logEntry);
        self::assertEquals($logEntry['context'], ['type' => 'mock-model-sibling-type', 'id' => '2']);

        self::assertArrayHasKey('level', $logEntry);
        self::assertEquals($logEntry['level'], Logger::INFO);
    }

    /**
     * @group integration
     */
    public function testResolveAndDecorateSubIncludes()
    {
        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                $this->resolveSubIncludeData
            )
        );

        /** @var MockModel $object */
        $object = $this->resolutionService->get('mock-model-type', 1);

        self::assertInstanceOf(MockModel::class, $object, 'Wrong object was created');
        self::assertInstanceOf(MockSiblingModel::class, $object->getObjectRaw(), 'Wrong subobject 1st level was created.');
        self::assertInstanceOf(MockSiblingModel::class, $object->getObjectRaw()->getObject(),
            'Wrong subobject 2nd level was created.');
    }

    /**
     * @group integration
     */
    public function testResolveSingleDataResponse()
    {
        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $response = new \Nordkirche\Ndk\Service\Response(
            $mockResponse,
            [
                'data' => $this->singelPrimaryData
            ]
        );

        $this->resolutionService->resolve($response);

        self::assertTrue($response->getPrimaryData() instanceof MockModel, 'Wrong object was created');
        self::assertEquals($response->getPrimaryData()->getId(), $this->singelPrimaryData['id'], 'Wrong value');
        self::assertEquals($response->getPrimaryData()->getType(), $this->singelPrimaryData['type'], 'Wrong value');
        self::assertEquals($response->getPrimaryData()->getInteger(), $this->singelPrimaryData['attributes']['integer'],
            'Wrong value');
        self::assertEquals($response->getPrimaryData()->getString(), $this->singelPrimaryData['attributes']['string'],
            'Wrong value');
    }

    /**
     * @group integration
     */
    public function testReturnResolutionProxyWhenSubIncludeIsMissing()
    {
        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                $this->skipSubRelationshipsWhenIncludeIsMissing
            )
        );

        /** @var MockModel $object */
        for ($i = 0; $i < 2; $i++) {
            $object = $this->resolutionService->get('mock-model-type', '1');

            self::assertTrue($object instanceof MockModel, 'Wrong object was created: ' . get_class($object));

            $resultObject = $object->getResultObject();

            self::assertEquals(3, $resultObject->count(), 'Resolved too many objects');

            /** @var MockSiblingModel $mockSibling */
            foreach ($resultObject as $i => $mockSibling) {
                if ($i === 1) {
                    self::assertInstanceOf(ResolutionProxy::class, $mockSibling);
                } else {
                    self::assertInstanceOf(MockSiblingModel::class, $mockSibling);
                }
            }
        }
    }

    /**
     * @group integration
     */
    public function testSkipMissingSubIncludes()
    {
        $this->api->getConfiguration()->setResolutionProxyDisabled(true);

        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                $this->skipSubRelationshipsWhenIncludeIsMissing
            )
        );

        /** @var MockModel $object */
        for ($i = 0; $i < 2; $i++) {
            $object = $this->resolutionService->get('mock-model-type', '1');

            self::assertTrue($object instanceof MockModel, 'Wrong object was created: ' . get_class($object));

            $resultObject = $object->getResultObject();

            self::assertEquals(2, $resultObject->count(), 'Resolved too many objects');

            /** @var MockSiblingModel $mockSibling */
            foreach ($resultObject as $mockSibling) {
                if ($mockSibling->getId() === '3') {
                    self::fail('Relationship with id 3 should never have been resolved');
                } else {
                    self::assertInstanceOf(MockSiblingModel::class, $mockSibling);
                }
            }
        }
    }

    /**
     * @group integration
     */
    public function testLogSkippedMissingSubIncludes()
    {
        $this->api->getConfiguration()->setResolutionProxyDisabled(true);

        $handler = $this->setUpLogger();

        /** @var \Psr\Http\Message\ResponseInterface $mockResponse */
        $mockResponse = $this->createMock(\Psr\Http\Message\ResponseInterface::class);

        $this->resolutionService->resolve(
            new \Nordkirche\Ndk\Service\Response(
                $mockResponse,
                $this->skipSubRelationshipsWhenIncludeIsMissing
            )
        );

        $log = $handler->close();

        self::assertNotEmpty($log);
        self::assertCount(1, $log);

        $logEntry = $log[0];
        self::assertArrayHasKey('message', $logEntry);
        self::assertEquals($logEntry['message'], 'Skipped relationship because it was not found in includes');

        self::assertArrayHasKey('context', $logEntry);
        self::assertEquals($logEntry['context'], ['type' => 'mock-model-sibling-type', 'id' => '3']);

        self::assertArrayHasKey('level', $logEntry);
        self::assertEquals($logEntry['level'], Logger::INFO);
    }
}
