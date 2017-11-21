<?php

namespace Nordkirche\Ndk\Domain\Endpoint;

use Nordkirche\Ndk\Domain\Query\SearchQuery;
use Nordkirche\Ndk\Service\Result;

class SearchEndpointTest extends \Nordkirche\Ndk\Helper\AbstractE2eTestCase
{

    /**
     * @group e2e
     */
    public function testQuery()
    {
        /* @var $search SearchEndpoint */
        $search = $this->api->factory(SearchEndpoint::class);

        $result = $search->query((new SearchQuery())->setQuery('Jesus'));

        self::assertInstanceOf(Result::class, $result);

        /** @var \Nordkirche\Ndk\Domain\Model\AbstractResourceObject $model */
        $model = $result->current();

        self::assertInstanceOf(\Nordkirche\Ndk\Domain\Model\MetaData::class, $model->getMetaData());
        self::assertInternalType('float', $model->getMetaData()->getScore());
    }
}
