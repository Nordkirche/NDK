<?php

namespace Nordkirche\Ndk\Domain\Model;

use Nordkirche\Ndk\Helper\MockModel;
use Nordkirche\Ndk\Service\Interfaces\ProxyInterface;
use PHPUnit\Framework\TestCase;

class AbstractModelTest extends TestCase
{

    /**
     * @group unit
     */
    public function testSetProxyInstanceOnDeclaredProperty()
    {
        $model = new MockModel();
        $proxy = $this->createMock(ProxyInterface::class);

        $model->__setProxyInstance('object', $proxy);

        self::assertSame($proxy, $model->getObjectRaw());
    }

    /**
     * @group unit
     */
    public function testSetProxyInstanceOnUndeclaredPropertyThrows()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionCode(1758710400);

        (new MockModel())->__setProxyInstance('not_declared', $this->createMock(ProxyInterface::class));
    }
}
