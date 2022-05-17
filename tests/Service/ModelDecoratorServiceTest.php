<?php

namespace Nordkirche\Ndk\Service;

use Nordkirche\Ndk\Helper\MockModel;
use Nordkirche\Ndk\Helper\MockSiblingModel;
use Prophecy\Prophecy\ObjectProphecy;

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
        /** @var MockModel|ObjectProphecy $model */
        $model = $this->prophesize(MockModel::class);
        $data = [
            'id' => 1,
            'type' => 'This is a very nice string mister.'
        ];
        $model->setId($data['id'])->shouldBeCalled();
        $model->setType($data['type'])->shouldBeCalled();
        $this->testSubject->decorateObject($model->reveal(), $data);
    }

    /**
     * @group integration
     */
    public function testDecoratingWithString()
    {
        /** @var MockModel|ObjectProphecy $model */
        $model = $this->prophesize(MockModel::class);
        $data = [
            'string' => 'This is a very nice string mister.',
        ];
        $model->setString($data['string'])->shouldBeCalled();
        $this->testSubject->decorateObject($model->reveal(), $data);
    }

    /**
     * @group integration
     */
    public function testDecoratingWithInteger()
    {
        /** @var MockModel|ObjectProphecy $model */
        $model = $this->prophesize(MockModel::class);
        $data = [
            'integer' => 74718,
        ];
        $model->setInteger($data['integer'])->shouldBeCalled();
        $this->testSubject->decorateObject($model->reveal(), $data);
    }

    /**
     * @group integration
     */
    public function testDecoratingWithObject()
    {
        /** @var MockModel|ObjectProphecy $model */
        $model = $this->prophesize(MockModel::class);

        $data = [
            'object' => [
                'integer' => 1,
                'string' => 'Some object string.'
            ],
        ];

        $expected = $this->api->factory()->get(MockSiblingModel::class);
        $expected->setInteger($data['object']['integer']);
        $expected->setString($data['object']['string']);

        $model->setObject($expected)->shouldBeCalled();
        $this->testSubject->decorateObject($model->reveal(), $data);
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
