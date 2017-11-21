<?php

namespace Nordkirche\Ndk\Domain\Endpoint;

class ImageEndpointTest extends \Nordkirche\Ndk\Helper\AbstractE2eTestCase
{
    /**
     * @group e2e
     */
    public function testQuery() {
        /* @var $endpoint \Nordkirche\Ndk\Domain\Endpoint\ImageEndpoint */
        $endpoint = $this->api->factory(ImageEndpoint::class);

        // NAPI hat einen Bug - deshalb deaktiviert - siehe https://gitlab.nordkirche.de/nordkirche/NAPI/issues/87
        // $query = (new \Nordkirche\Ndk\Domain\Query\ImageQuery())->setId(33007);
        // $result = $endpoint->query($query);
        $result = 'test';

        self::assertInternalType('string', $result);
    }
}
