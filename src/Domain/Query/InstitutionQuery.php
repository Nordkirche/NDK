<?php

namespace Nordkirche\Ndk\Domain\Query;

use Nordkirche\Ndk\Domain\Model\Geocode;

class InstitutionQuery extends PageQuery
{
    const SORT_BY_NAME = 'name';
    
    protected $sort = self::SORT_BY_NAME;

    protected $filterProperties = [
        'ancestorInstitutions',
        'ancestorInstitutionsOrSelf',
        'categories',
        'geocode',
        'parentInstitutions',
        'parentInstitutionsOrSelf',
        'institutionType',
        'cities' => 'cities',
        'plz' => 'zipCodes',
        'id' => 'institutions',
        'q' => 'query'
    ];

    /**
     * @var integer[]
     */
    protected $ancestorInstitutions = [];

    /**
     * @var integer[]
     */
    protected $ancestorInstitutionsOrSelf = [];

    /**
     * @var integer[]
     */
    protected $categories = [];

    /**
     * @var Geocode
     */
    protected $geocode = null;

    /**
     * @var integer[]
     */
    protected $parentInstitutions = [];

    /**
     * @var integer[]
     */
    protected $parentInstitutionsOrSelf = [];

    /**
     * @var integer[]
     */
    protected $institutions = [];

    /**
     * @var integer[]
     */
    protected $institutionType = [];

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
     * @return integer[]
     */
    public function getAncestorInstitutions(): array
    {
        return $this->ancestorInstitutions;
    }

    /**
     * @param integer[] $ancestorInstitutions
     *
     * @return InstitutionQuery
     */
    public function setAncestorInstitutions(array $ancestorInstitutions): InstitutionQuery
    {
        $this->ancestorInstitutions = $ancestorInstitutions;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getAncestorInstitutionsOrSelf(): array
    {
        return $this->ancestorInstitutionsOrSelf;
    }

    /**
     * @param integer[] $ancestorInstitutionsOrSelf
     *
     * @return InstitutionQuery
     */
    public function setAncestorInstitutionsOrSelf(array $ancestorInstitutionsOrSelf): InstitutionQuery
    {
        $this->ancestorInstitutionsOrSelf = $ancestorInstitutionsOrSelf;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param integer[] $categories
     *
     * @return InstitutionQuery
     */
    public function setCategories(array $categories): InstitutionQuery
    {
        $this->categories = $categories;

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
     * @return InstitutionQuery
     */
    public function setGeocode(Geocode $geocode): InstitutionQuery
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
     * @return InstitutionQuery
     */
    public function setInstitutions(array $institutions): InstitutionQuery
    {
        $this->institutions = $institutions;

        return $this;
    }
    
    /**
     * @return integer[]
     */
    public function getParentInstitutions(): array
    {
        return $this->parentInstitutions;
    }

    /**
     * @param integer[] $parentInstitutions
     *
     * @return InstitutionQuery
     */
    public function setParentInstitutions(array $parentInstitutions): InstitutionQuery
    {
        $this->parentInstitutions = $parentInstitutions;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getParentInstitutionsOrSelf(): array
    {
        return $this->parentInstitutionsOrSelf;
    }

    /**
     * @param integer[] $parentInstitutionsOrSelf
     *
     * @return InstitutionQuery
     */
    public function setParentInstitutionsOrSelf(array $parentInstitutionsOrSelf): InstitutionQuery
    {
        $this->parentInstitutionsOrSelf = $parentInstitutionsOrSelf;

        return $this;
    }

    /**
     * @return array
     */
    public function getInstitutionType(): array
    {
        return $this->institutionType;
    }

    /**
     * @param array $institutionType
     *
     * @return InstitutionQuery
     */
    public function setInstitutionType(array $institutionType): InstitutionQuery
    {
        $this->institutionType = $institutionType;

        return $this;
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
     */
    public function setQuery(string $query)
    {
        $this->query = $query;
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
     * @return InstitutionQuery
     */
    public function setZipCodes(array $zipCodes): InstitutionQuery
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
     * @return InstitutionQuery
     */
    public function setCities(array $cities): InstitutionQuery
    {
        $this->cities = $cities;

        return $this;
    }
}
