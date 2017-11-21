<?php

namespace Nordkirche\Ndk\Domain\Query;

use Nordkirche\Ndk\Domain\Interfaces\QueryParameterValue;
use Nordkirche\Ndk\Service\Interfaces\QueryInterface;
use Nordkirche\Ndk\Service\NapiService;

abstract class AbstractQuery implements QueryInterface
{

    /**
     * Define class properties to use as url parameters
     * @var array
     */
    protected $filterProperties = [];

    /**
     * Define relations which should be included to avoid additional requests
     * @var array
     */
    protected $include = [];

    /**
     * Define facets which should be included in response
     * @var array
     */
    protected $facets = [];

    public function __toString(): string
    {
        $string = '';
        $urlParameters = $this->returnUrlParameters();
        if ((bool)$urlParameters) {
            $string = '?' . http_build_query($urlParameters);
        }

        return $string;
    }

    public function returnUrlParameters(): array
    {
        $parameters = [];

        foreach ($this->filterProperties as $parameter => $property) {
            $value = $this->returnValueForProperty($property);

            if ($value !== '' && $value !== null) {
                $filterName = is_string($parameter)
                    ? $parameter
                    : \Nordkirche\Ndk\Service\StringUtilites::decamelize($property);

                $parameters['filter'][$filterName] = $value;
            }
        }

        if ((bool)$this->include) {
            $parameters['include'] = implode(',', $this->include);
        }

        if ((bool)$this->facets) {
            $parameters['facets'] = implode(',', $this->facets);
        }

        return $parameters;
    }

    /**
     * @param string $property
     *
     * @return string
     */
    protected function returnValueForProperty(string $property)
    {
        $value = $this->replaceNapiUrls($this->{$property});

        if (is_string($value)) {
            return trim($value);
        } elseif (is_array($value)) {
            return implode(',', $value);
        } elseif ($value instanceof \DateTime) {
            return $value->format(\DateTime::ISO8601);
        } elseif ($value instanceof QueryParameterValue) {
            return $value->returnParameterValue();
        }

        return $value;
    }

    /**
     * Can resolve an mixed array or a single value which contains NAPI URLs
     *
     * @param $value
     *
     * @return array|mixed
     */
    protected function replaceNapiUrls($value)
    {
        if (is_array($value)) {
            return array_map(function ($entry) {
                return $this->returnIdFromNapiUrl($entry);
            }, $value);
        } else {
            if (is_string($value)) {
                return $this->returnIdFromNapiUrl($value);
            }
        }

        return $value;
    }

    /**
     * Resolves a NAPI URL to its Id or returns the orignal value
     *
     * @param $value
     *
     * @return mixed
     */
    protected function returnIdFromNapiUrl($value)
    {
        if (NapiService::isUrl($value)) {
            return NapiService::parseResourceUrl($value)[1];
        } else {
            return $value;
        }
    }

    /**
     * @param array $filterProperties
     */
    public function setFilterProperties(array $filterProperties)
    {
        $this->filterProperties = $filterProperties;
    }

    /**
     * @return array
     */
    public function getInclude(): array
    {
        return $this->include;
    }

    /**
     * Use SomeResourceObject::RELATION_* constants to create an array with relations to include
     *
     * @param array $include
     *
     * @return AbstractQuery
     */
    public function setInclude(array $include): AbstractQuery
    {
        $parsedIncludes = [];

        foreach ($include as $key => $relation) {
            if (is_array($relation)) {
                foreach ($relation as $childkey => $child_relation) {
                    if (is_array($child_relation)) {
                        foreach ($child_relation as $grand_child_relation) {
                            $parsedIncludes[] = sprintf('%s.%s.%s', $key, $childkey, $grand_child_relation);
                        }
                    } else {
                        $parsedIncludes[] = sprintf('%s.%s', $key, $child_relation);
                    }
                }
            } else {
                $parsedIncludes[] = $relation;
            }
        }

        $this->include = $parsedIncludes;

        return $this;
    }

    /**
     * @return array
     */
    public function getFacets(): array
    {
        return $this->facets;
    }

    /**
     * @param array $facets
     */
    public function setFacets(array $facets)
    {
        $this->facets = $facets;
    }
}
