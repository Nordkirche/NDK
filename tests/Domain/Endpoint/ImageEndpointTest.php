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

        $query = (new \Nordkirche\Ndk\Domain\Query\ImageQuery())->setId(33007);
        $result = $endpoint->query($query);

        self::assertInternalType('string', $result);
    }
}
