<?php

namespace Nordkirche\Ndk\Service;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Nordkirche\Ndk\Domain\Model\Institution\Institution;
use Nordkirche\Ndk\Domain\Model\ResourcePlaceholder;
use Nordkirche\Ndk\Helper\AbstractIntegrationTestCase;
use Nordkirche\Ndk\Service\Exception\AccessDeniedException;
use Nordkirche\Ndk\Service\Exception\ResourceObjectNotFoundException;
use Nordkirche\Ndk\Service\Exception\ServerException;

class ResolutionProxyTest extends AbstractIntegrationTestCase
{

    /**
     * @group integration
     */
    public function testResolveResource()
    {
        $this->mockResponses([
            new GuzzleResponse(200, [], file_get_contents('./tests/Service/Fixtures/institution.json')),
        ]);

        $testSubject = $this->api->factory()->make(ResolutionProxy::class, ['uri' => 'institutions/12054']);
        $result = $testSubject->resolve();

        self::assertTrue($result instanceof Institution);
    }

    /**
     * @group integration
     */
    public function testAddResolvedObjectToObjectMap()
    {
        $this->mockResponses([
            new GuzzleResponse(200, [], file_get_contents('./tests/Service/Fixtures/institution.json')),
        ]);

        $testSubject = $this->api->factory()->make(ResolutionProxy::class, ['uri' => 'institutions/12054']);
        $result = $testSubject->resolve();
        self::assertTrue($result instanceof Institution);

        /** @var \Nordkirche\Ndk\Service\ResolutionService $resolutionService */
        $resolutionService = $this->api->factory()->get(\Nordkirche\Ndk\Service\ResolutionService::class);
        self::assertTrue(
            $resolutionService->get('institutions', 12054) instanceof Institution,
            'Resolved object is not in ResolutionServices object map'
        );
    }

    public function resourcePlaceHolderRequestDataProvider()
    {
        return [
            '404' => [new GuzzleResponse(404, [], ''), ResourceObjectNotFoundException::class],
            '500' => [new GuzzleResponse(500, [], ''), ServerException::class],
        ];
    }

    public function bubblingExceptionRequestDataProvider()
    {
        return [
            '401' => [new GuzzleResponse(401, [], ''), AccessDeniedException::class],
            '403' => [new GuzzleResponse(403, [], ''), AccessDeniedException::class],
        ];
    }

    /**
     * @group integration
     *
     * @param GuzzleResponse $request
     * @param string $expectedLinkedException
     *
     * @dataProvider resourcePlaceHolderRequestDataProvider
     */
    public function testResolveToResourcePlaceholder(GuzzleResponse $request, string $expectedLinkedException)
    {
        $this->mockResponses([$request]);

        $testSubject = $this->api->factory()->make(ResolutionProxy::class, ['uri' => 'institutions/1']);

        /** @var ResourcePlaceholder $result */
        $result = $testSubject->resolve();

        self::assertTrue($result instanceof ResourcePlaceholder);
        self::assertInstanceOf($expectedLinkedException, $result->getLinkedException());
    }

    /**
     * @group integration
     *
     * @param GuzzleResponse $request
     * @param string $expectedException
     *
     * @dataProvider bubblingExceptionRequestDataProvider
     */
    public function testResolveButThrowException(GuzzleResponse $request, string $expectedException)
    {
        self::expectException($expectedException);

        $this->mockResponses([$request]);

        $testSubject = $this->api->factory()->make(ResolutionProxy::class, ['uri' => 'institutions/1']);
        $testSubject->resolve();
    }
}
