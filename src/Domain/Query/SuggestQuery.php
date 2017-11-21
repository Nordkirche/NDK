<?php

namespace Nordkirche\Ndk\Domain\Query;

class SuggestQuery extends SimpleQuery implements \Nordkirche\Ndk\Service\Interfaces\QueryInterface
{

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var array
     */
    protected $resources = [];


    public function __toString(): string
    {
        $string = '/' . rawurlencode($this->query);

        $query = $this->returnUrlParameters();

        if ((bool)$this->resources) {
            $query['types'] = implode(',', $this->resources);
        }

        $string .= '/?'.http_build_query($query);

        return $string;
    }

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
     * @return SuggestQuery
     */
    public function setQuery(string $query): SuggestQuery
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return array
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * @param array $resources
     *
     * @return SuggestQuery
     */
    public function setResources(array $resources): SuggestQuery
    {
        $this->resources = $resources;

        return $this;
    }
}
