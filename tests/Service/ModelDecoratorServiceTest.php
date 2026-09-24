<?php

namespace Nordkirche\Ndk\Service;

use Nordkirche\Ndk\Helper\MockModel;
use Nordkirche\Ndk\Helper\MockSiblingModel;
use PHPUnit\Framework\MockObject\MockObject;

class ModelDecoratorServiceTest extends \Nordkirche\Ndk\Helper\AbstractIntegrationTestCase
{

    /**
     * @var ModelDecoratorService
     */
    protected $testSubject;

    public function setUp(): void
    {
        parent::setUp();
        $this->testSubject = $this->api->factory()->get(ModelDecoratorService::class);
    }

    /**
     * @group integration
     */
    public function testDecoratingIdAndType()
    {
        /** @var MockModel|MockObject $model */
        $model = $this->createMock(MockModel::class);
        $data = [
            'id' => 1,
            'type' => 'This is a very nice string mister.'
        ];
        $model->expects(self::once())->method('setId')->with($data['id']);
        $model->expects(self::once())->method('setType')->with($data['type']);
        $this->testSubject->decorateObject($model, $data);
    }

    /**
     * @group integration
     */
    public function testDecoratingWithString()
    {
        /** @var MockModel|MockObject $model */
        $model = $this->createMock(MockModel::class);
        $data = [
            'string' => 'This is a very nice string mister.',
        ];
        $model->expects(self::once())->method('setString')->with($data['string']);
        $this->testSubject->decorateObject($model, $data);
    }

    /**
     * @group integration
     */
    public function testDecoratingWithInteger()
    {
        /** @var MockModel|MockObject $model */
        $model = $this->createMock(MockModel::class);
        $data = [
            'integer' => 74718,
        ];
        $model->expects(self::once())->method('setInteger')->with($data['integer']);
        $this->testSubject->decorateObject($model, $data);
    }

    /**
     * @group integration
     */
    public function testDecoratingWithObject()
    {
        /** @var MockModel|MockObject $model */
        $model = $this->createMock(MockModel::class);

        $data = [
            'object' => [
                'integer' => 1,
                'string' => 'Some object string.'
            ],
        ];

        $expected = $this->api->factory()->get(MockSiblingModel::class);
        $expected->setInteger($data['object']['integer']);
        $expected->setString($data['object']['string']);

        $model->expects(self::once())->method('setObject')->with($expected);
        $this->testSubject->decorateObject($model, $data);
    }

    /**
     * @group integration
     */
    public function testDecoratingWithResultObject()
    {
        $model = $this->api->factory()->get(MockModel::class);

        $data = [
            'resultObject' => [
                [
                    'integer' => 1,
                    'string' => 'Some object string.'
                ]
            ],
        ];

        /** @var MockModel $model */
        $this->testSubject->decorateObject($model, $data);

        $this->assertEquals(
            $data['resultObject'][0]['integer'],
            $model->getResultObject()->current()->getInteger()
        );

        $this->assertEquals(
            $data['resultObject'][0]['string'],
            $model->getResultObject()->current()->getString()
        );
    }
}
