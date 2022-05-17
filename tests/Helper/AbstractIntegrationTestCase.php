<?php

namespace Nordkirche\Ndk\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Nordkirche\Ndk\Configuration;
use Nordkirche\Ndk\Service\NapiService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

abstract class AbstractIntegrationTestCase extends TestCase
{

    use SetupApiTrait;

    /**
     * @var \Nordkirche\Ndk\Api
     */
    protected $api;

    protected function setUp(): void
    {
        $this->api = $this->createApiInstance(new Configuration(1, 'foobar'));
    }

    protected function setUpLogger(): ArrayLogHandler
    {
        $handler = new ArrayLogHandler;
        $logger = new \Monolog\Logger(
            'buffer',
            [$handler]
        );

        $this->api->getConfiguration()->setLogger($logger);

        return $handler;
    }

    /**
     * @param Response[] $responses
     */
    protected function mockResponses(array $responses)
    {
        $napiService = $this->api->factory(NapiService::class);

        $mock = new MockHandler($responses);

        $handlerStack = HandlerStack::create($mock);

        $client = new Client(['handler' => $handlerStack]);

        $reflection = new ReflectionClass($napiService);
        $reflectionProperty = $reflection->getProperty('client');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($napiService, $client);
    }
}