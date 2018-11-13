<?php

namespace Nordkirche\Ndk\Domain\Query;

use Nordkirche\Ndk\Domain\Model\Geocode;
use Nordkirche\Ndk\Domain\Traits\LastModifiedFilters;

class PersonQuery extends PageQuery
{

    use LastModifiedFilters;

    const SORT_BY_FIRST_NAME = 'first_name';
    const SORT_BY_LAST_NAME = 'last_name';

    protected $sort = self::SORT_BY_LAST_NAME;

    protected $filterProperties = [
        'ancestorInstitutions',
        'geocode',
        'institutions',
        'functions',
        'available_functions' => 'availableFunctions',
        'cities' => 'cities',
        'plz' => 'zipCodes',
        'id' => 'persons',
        'q' => 'query'
    ];

    /**
     * @var integer[]
     */
    protected $ancestorInstitutions = [];

    /**
     * @var Geocode
     */
    protected $geocode = null;

    /**
     * @var integer[]
     */
    protected $institutions = [];

    /**
     * @var integer[]
     */
    protected $functions = [];

    /**
     * @var integer[]
     */
    protected $availableFunctions = [];

    /**
     * @var array
     */
    protected $persons = [];

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var integer[]
     */
    protected $zipCodes = [];

    /**
     * @var string[]
     */
    protected $cities = [];

    /**
     * @return array
     */
    public function getFilterProperties(): array
    {
        return $this->filterProperties;
    }

    /**
     * @param array $filterProperties
     *
     * @return PersonQuery
     */
    public function setFilterProperties(array $filterProperties): PersonQuery
    {
        $this->filterProperties = $filterProperties;

        return $this;
    }

    /**
     * @return \integer[]
     */
    public function getAncestorInstitutions(): array
    {
        return $this->ancestorInstitutions;
    }

    /**
     * @param \integer[] $ancestorInstitutions
     *
     * @return PersonQuery
     */
    public function setAncestorInstitutions(array $ancestorInstitutions): PersonQuery
    {
        $this->ancestorInstitutions = $ancestorInstitutions;

        return $this;
    }

    /**
     * @return Geocode
     */
    public function getGeocode(): Geocode
    {
        return $this->geocode;
    }

    /**
     * @param Geocode $geocode
     *
     * @return PersonQuery
     */
    public function setGeocode(Geocode $geocode): PersonQuery
    {
        $this->geocode = $geocode;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getInstitutions(): array
    {
        return $this->institutions;
    }

    /**
     * @param integer[] $institutions
     *
     * @return PersonQuery
     */
    public function setInstitutions(array $institutions): PersonQuery
    {
        $this->institutions = $institutions;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getFunctions(): array
    {
        return $this->functions;
    }

    /**
     * @param integer[] $functions
     *
     * @return PersonQuery
     */
    public function setFunctions(array $functions): PersonQuery
    {
        $this->functions = $functions;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getAvailableFunctions(): array
    {
        return $this->availableFunctions;
    }

    /**
     * @param integer[] $availableFunctions
     *
     * @return PersonQuery
     */
    public function setAvailableFunctions(array $availableFunctions): PersonQuery
    {
        $this->availableFunctions = $availableFunctions;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getPersons(): array
    {
        return $this->persons;
    }

    /**
     * @param integer[] $persons
     */
    public function setPersons(array $persons)
    {
        $this->persons = $persons;
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
     * @return PersonQuery
     */
    public function setQuery(string $query): PersonQuery
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getZipCodes(): array
    {
        return $this->zipCodes;
    }

    /**
     * @param integer[] $zipCodes
     *
     * @return PersonQuery
     */
    public function setZipCodes(array $zipCodes): PersonQuery
    {
        $this->zipCodes = $zipCodes;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getCities(): array
    {
        return $this->cities;
    }

    /**
     * @param string[] $cities
     *
     * @return PersonQuery
     */
    public function setCities(array $cities): PersonQuery
    {
        $this->cities = $cities;

        return $this;
    }
}
