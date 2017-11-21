<?php

namespace Nordkirche\Ndk\Service;

use Nordkirche\Ndk\Service;

class FactoryServiceTest extends \Nordkirche\Ndk\Helper\AbstractIntegrationTestCase
{
    /**
     * @var \Nordkirche\Ndk\Service\FactoryService
     */
    private $testSubject;

    public function setUp()
    {
        parent::setUp();
        $this->testSubject = $this->api->factory();
    }

    /**
     * @group integration
     */
    public function testGet()
    {
        $expectedClasses = [
            Service\NapiService::class,
        ];

        foreach($expectedClasses as $expectedClass) {
            $result = $this->testSubject->get($expectedClass);
            $this->assertTrue($result instanceof $expectedClass);
        }
    }
}
