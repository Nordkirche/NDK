<?php

namespace Nordkirche\Ndk\Helper;

use Nordkirche\Ndk\Api;
use Nordkirche\Ndk\Configuration;
use PHPUnit\Framework\TestCase;

abstract class AbstractE2eTestCase extends TestCase
{
    use SetupApiTrait;

    /**
     * @var \Nordkirche\Ndk\Api
     */
    protected $api;

    protected function setUp(): void
    {
        $this->api = $this->createApiInstance();
    }
}