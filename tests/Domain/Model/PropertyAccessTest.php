<?php

namespace Nordkirche\Ndk\Domain\Model;

use Nordkirche\Ndk\Helper\MockModel;
use Nordkirche\Ndk\Helper\MockSiblingModel;
use PHPUnit\Framework\TestCase;

class PropertyAccessTest extends TestCase
{

    /**
     * @group unit
     */
    public function testAccessProtectedPropertyAsPublic()
    {
        $modelSibling = new MockSiblingModel();

        $model = new MockModel();
        $model->setObject($modelSibling);

        self::assertEquals($modelSibling, $model->getObject());
        self::assertEquals($modelSibling, $model->object);
    }
}