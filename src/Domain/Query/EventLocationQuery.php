<?php

namespace Nordkirche\Ndk\Domain\Query;

use Nordkirche\Ndk\Domain\Traits\LastModifiedFilters;

class EventLocationQuery extends PageQuery
{
    use LastModifiedFilters;

    const SORT_BY_NAME = 'name';

    protected $sort = self::SORT_BY_NAME;
    
    protected $filterProperties = [
        'id' => 'event_locations',
        'q' => 'query'
    ];

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     *
     * @return EventQuery
     */
    public function setQuery(string $query): EventLocationQuery
    {
        $this->query = $query;

        return $this;
    }
}
