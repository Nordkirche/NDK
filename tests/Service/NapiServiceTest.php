<?php

namespace Nordkirche\Ndk\Service;

use Nordkirche\Ndk\Api;
use Nordkirche\Ndk\Configuration;
use Nordkirche\Ndk\Helper\SetupApiTrait;
use PHPUnit\Framework\TestCase;
use Nordkirche\Ndk\Helper\MockResourceObject;

class NapiServiceTest extends TestCase
{

    use SetupApiTrait;

    /**
     * @var NapiService
     */
    private $testSubject;

    /**
     * @group e2e
     * @expectedException \Nordkirche\Ndk\Service\Exception\RequestException
     * @expectedExceptionCode 1494246071
     */
    public function testWrongRequest()
    {
        $this->setUpE2e();
        $this->testSubject->get('');
    }

    public function setUpE2e()
    {
        $api = $this->createApiInstance();
        $this->testSubject = $api->factory()->get(NapiService::class);
    }

    public function setUpIntegration()
    {
        $api = $this->createApiInstance(new Configuration(1,'FooBar'));
        $this->testSubject = $api->factory()->get(NapiService::class);
    }

    /**
     * @group e2e
     * @expectedException \Nordkirche\Ndk\Service\Exception\ResourceObjectNotFoundException
     * @expectedExceptionCode 1496261856
     */
    public function testResourceObjectNotFound()
    {
        $this->setUpE2e();
        $this->testSubject->get('institutions/0');
    }

    /**
     * @group e2e
     */
    public function testReturnResourcePlaceHolder()
    {
        $this->setUpE2e();
        $result = $this->testSubject->resolveUrl('napi://resource/institutions/0');
        self::assertInstanceOf(\Nordkirche\Ndk\Domain\Model\ResourcePlaceholder::class, $result);
        self::assertEquals(0, $result->getId());
        self::assertEquals('institutions', $result->getType());
    }

    /**
     * @group e2e
     */
    public function testReturnResourcePlaceHolderMixedList()
    {
        $this->setUpE2e();
        $result = $this->testSubject->resolveUrls([
            'napi://resource/institutions/0',
            'napi://resource/institutions/1',
            'napi://resource/institutions/2'
        ]);
        self::assertInstanceOf(\Nordkirche\Ndk\Domain\Model\ResourcePlaceholder::class, $result[0]);
        self::assertInstanceOf(\Nordkirche\Ndk\Domain\Model\Institution\Institution::class, $result[1]);
        self::assertInstanceOf(\Nordkirche\Ndk\Domain\Model\Institution\Institution::class, $result[2]);
    }

    /**
     * @param $url
     *
     * @group e2e
     * @dataProvider urlProvider
     */
    public function testResolveUrl($url)
    {
        $this->setUpE2e();
        self::assertTrue(
            $this->testSubject->resolveUrl($url) instanceof \Nordkirche\Ndk\Domain\Model\Institution\Institution,
            'Model could not be retrieved'
        );
    }

    /**
     * @group e2e
     */
    public function testResolveUrls()
    {
        $this->setUpE2e();
        $result = $this->testSubject->resolveUrls($this->urlProvider()[0]);

        self::assertTrue(is_array($result), 'Does not return an array');

        self::assertContainsOnlyInstancesOf(
            \Nordkirche\Ndk\Domain\Model\Institution\Institution::class,
            $result,
            'Does not containt correct model');
    }

    public function urlProvider()
    {
        return [
            ['napi://resource/institutions/1'],
            ['napi://resource/institutions/2'],
            ['napi://resource/institutions/3'],
        ];
    }

    /**
     * @group e2e
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 1495196889
     */
    public function testThrowExceptionOnWrongResource()
    {
        $this->setUpE2e();
        $this->testSubject->resolveUrl('napi://resource/somefoobarstuff/123');
    }

    /**
     * @group e2e
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 1495185925
     */
    public function testThrowExceptionOnWrongDomain()
    {
        $this->setUpE2e();
        $this->testSubject->resolveUrl('napi://somegibberish/institutions/1');
    }

    /**
     * @group integration
     */
    public function testReflectionCacheIsAskedForResourceObjectFirst()
    {
        $this->setUpIntegration();
        $configuration = Api::$api->getConfiguration()->setTypeClassMap([
            'sometype' => \Nordkirche\Ndk\Helper\MockModel::class
        ]);
        $resolutionService = Api::$api->factory()->get(ResolutionService::class);

        /** @var \GuzzleHttp\Client|\PHPUnit_Framework_MockObject_MockObject $stubClient */
        $stubClient = $this->createMock(\GuzzleHttp\Client::class);
        $stubClient->expects($this->once())
                   ->method('request')
                   ->will($this->returnValue(new \GuzzleHttp\Psr7\Response()));

        /** @var NapiService|\PHPUnit_Framework_MockObject_MockObject $napiServiceMock */
        $napiServiceMock = $this
            ->getMockBuilder(NapiService::class)
            ->setMethods(['buildResponseObject'])
            ->setConstructorArgs([$stubClient, $resolutionService, $configuration])
            ->getMock();

        $napiServiceMock
            ->method('buildResponseObject')
            ->will($this->returnValue(
                new \Nordkirche\Ndk\Service\Response(new \GuzzleHttp\Psr7\Response(), [
                    'data' => [
                        'id' => '123',
                        'type' => 'sometype',
                        'attributes' => [
                            'integer' => 1,
                            'string' => 'abcdEFGH',
                            'array' => [1, 2, 3],
                        ]
                    ]
                ])
            ));

        $object1 = $napiServiceMock->get('sometype/123');

        self::assertTrue($resolutionService->has('sometype', 123));

        $object2 = $napiServiceMock->get('sometype/123');

        self::assertTrue($object1 === $object2);
    }

    public function resourceObjectProvider()
    {
        $resourceObject[] = new MockResourceObject;
        $resourceObject[] = new MockResourceObject;
        $resourceObject[] = new MockResourceObject;

        $resourceObject[0]->id = 770;
        $resourceObject[1]->id = 771;
        $resourceObject[2]->id = 772;
        $resourceObject[2]->type = 'othermockresource';

        return [
            [$resourceObject[0], 'napi://resource/mockresources/770'],
            [$resourceObject[1], 'napi://resource/mockresources/771'],
            [$resourceObject[2], 'napi://resource/othermockresource/772']
        ];
    }

    /**
     * @param $resourceObject
     * @param $link
     *
     * @group unit
     * @dataProvider resourceObjectProvider
     */
    public function testReturnNapiUrl($resourceObject, $link)
    {
        self::assertEquals(\Nordkirche\Ndk\Service\NapiService::returnNapiUrlFromObject($resourceObject), $link);
    }

    /**
     * @group unit
     */
    public function testIsUrl()
    {
        self::assertTrue(\Nordkirche\Ndk\Service\NapiService::isUrl('napi://foo/bar/123'));
        self::assertFalse(\Nordkirche\Ndk\Service\NapiService::isUrl('SomewildString'));
    }

    /**
     * @group unit
     */
    public function testParseResourceUrl()
    {
        self::assertEquals('bar', \Nordkirche\Ndk\Service\NapiService::parseResourceUrl('napi://foo/bar/123')[0]);
        self::assertEquals(123, \Nordkirche\Ndk\Service\NapiService::parseResourceUrl('napi://foo/bar/123')[1]);
    }
}
