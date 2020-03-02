<?php

namespace Nordkirche\Ndk\Helper;

use Nordkirche\Ndk\Configuration;
use PHPUnit\Framework\TestCase;

abstract class AbstractIntegrationTestCase extends TestCase
{

    use SetupApiTrait;

    /**
     * @var \Nordkirche\Ndk\Api
     */
    protected $api;

    public function setUp()
    {
        $this->api = $this->createApiInstance(new Configuration(1, 'foobar'));
    }

    public function setUpLogger(): ArrayLogHandler {
        $handler = new ArrayLogHandler;
        $logger = new \Monolog\Logger(
            'buffer',
            [$handler]
        );

        $this->api->getConfiguration()->setLogger($logger);

        return $handler;
    }
}