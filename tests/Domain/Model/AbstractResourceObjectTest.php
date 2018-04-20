<?php

namespace Nordkirche\Ndk\Domain\Model;

class AbstractResourceObjectTest extends \Nordkirche\Ndk\Helper\AbstractIntegrationTestCase
{

    private $fixture = [
        'last_modified' => '2017-02-21T15:17:47+0000'
    ];

    /**
     * @group integration
     */
    public function testDecorate()
    {
        /** @var AbstractResourceObject $abstractResourceObject */
        $abstractResourceObject = self::getMockForAbstractClass(AbstractResourceObject::class);

        /** @var \Nordkirche\Ndk\Service\ModelDecoratorService $decoratorService */
        $decoratorService = $this->api->factory(\Nordkirche\Ndk\Service\ModelDecoratorService::class);

        /** @var AbstractResourceObject $decoratedObject */
        $decoratedObject = $decoratorService->decorateObject($abstractResourceObject, $this->fixture);

        self::assertInstanceOf(\DateTime::class, $decoratedObject->getLastModified());
        self::assertEquals(
            $this->fixture['last_modified'],
            $decoratedObject->getLastModified()->format(\DateTime::ISO8601)
        );
    }
}
