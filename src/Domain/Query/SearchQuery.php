<?php

namespace Nordkirche\Ndk\Domain\Query;

class SearchQuery extends PageQuery implements \Nordkirche\Ndk\Service\Interfaces\QueryInterface
{

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var array
     */
    protected $fieldsInstitutions = [];

    /**
     * @var array
     */
    protected $fieldsPeople = [];

    /**
     * @var array
     */
    protected $resources = [];


    public function __toString(): string
    {
        $string = '/' . rawurlencode(preg_replace("/[^a-z\d_äöüß ]/si", '', mb_strtolower($this->query)));

        $query = $this->returnUrlParameters();

        if ((bool)$this->fieldsInstitutions || (bool)$this->fieldsPeople || sizeof($query)) {
            $string .= '?';
        }

        if ((bool)$this->fieldsPeople) {
            $query['fields']['people'] = implode(',', $this->fieldsPeople);
        }

        if ((bool)$this->fieldsInstitutions) {
            $query['fields']['institutions'] = implode(',', $this->fieldsInstitutions);
        }

        if ((bool)$this->resources) {
            $query['resources'] = implode(',', $this->resources);
        }

        $string .= http_build_query($query);

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
     * @return SearchQuery
     */
    public function setQuery(string $query): SearchQuery
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldsInstitutions(): array
    {
        return $this->fieldsInstitutions;
    }

    /**
     * @param array $fieldsInstitutions
     *
     * @return SearchQuery
     */
    public function setFieldsInstitutions(array $fieldsInstitutions): SearchQuery
    {
        $this->fieldsInstitutions = $fieldsInstitutions;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getFieldsPeople(): array
    {
        return $this->fieldsPeople;
    }

    /**
     * @param string[] $fieldsPeople
     *
     * @return SearchQuery
     */
    public function setFieldsPeople(array $fieldsPeople): SearchQuery
    {
        $this->fieldsPeople = $fieldsPeople;

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
     * @return SearchQuery
     */
    public function setResources(array $resources): SearchQuery
    {
        $this->resources = $resources;

        return $this;
    }
}
