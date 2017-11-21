<?php

namespace Nordkirche\Ndk\Service;

class ResolutionProxyTest extends \Nordkirche\Ndk\Helper\AbstractE2eTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @group e2e
     */
    public function testResolve()
    {
        $testSubject = $this->api->factory()->make(ResolutionProxy::class, ['uri' => 'institutions/1']);
        $result = $testSubject->resolve();
        self::assertTrue($result instanceof \Nordkirche\Ndk\Domain\Model\Institution\Institution);

        $testSubject = $this->api->factory()->make(ResolutionProxy::class, ['uri' => 'institutions/1/address']);
        $result = $testSubject->resolve();
        self::assertTrue($result instanceof \Nordkirche\Ndk\Domain\Model\Address);
    }

    /**
     * @group e2e
     */
    public function testAddResolvedObjectToObjectMap()
    {
        $testSubject = $this->api->factory()->make(ResolutionProxy::class, ['uri' => 'institutions/1/address']);
        $result = $testSubject->resolve();
        self::assertTrue($result instanceof \Nordkirche\Ndk\Domain\Model\Address);

        /** @var \Nordkirche\Ndk\Service\ResolutionService $resolutionService */
        $resolutionService = $this->api->factory()->get(\Nordkirche\Ndk\Service\ResolutionService::class);
        self::assertTrue(
            $resolutionService->get('addresses', 1) instanceof \Nordkirche\Ndk\Domain\Model\Address,
            'Resolved object is not in ResolutionServices object map'
        );
    }
}
