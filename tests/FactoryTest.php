<?php

namespace Nordkirche\Ndk;

use Nordkirche\Ndk\Helper\AbstractIntegrationTestCase;
use Nordkirche\Ndk\Service\FactoryService;

class FactoryTest extends AbstractIntegrationTestCase
{

    /**
     * @var Api
     */
    private $testSubject;

    public function setUp()
    {
        parent::setUp();
        $this->testSubject = $this->api;
    }

    /**
     * @group integration
     */
    public function testFactoryIsPresent()
    {
        $this->assertTrue($this->testSubject->factory() instanceof FactoryService);
    }
}
