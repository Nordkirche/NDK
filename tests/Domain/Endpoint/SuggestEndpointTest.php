<?php

namespace Nordkirche\Ndk\Domain\Endpoint;

use Nordkirche\Ndk\Domain\Query\SuggestQuery;
use Nordkirche\Ndk\Service\Result;

class SuggestEndpointTest extends \Nordkirche\Ndk\Helper\AbstractE2eTestCase
{

    /**
     * @group e2e
     */
    public function testQuery()
    {
        /* @var $search SearchEndpoint */
        $search = $this->api->factory(SuggestEndpoint::class);

        $result = $search->query((new SuggestQuery())->setQuery('Kir'));

        self::assertTrue(is_array($result), 'Result is not an array');
        self::assertNotEmpty($result, 'Result should not be empty');
    }
}
