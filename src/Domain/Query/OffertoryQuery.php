<?php

namespace Nordkirche\Ndk\Domain\Query;

use Nordkirche\Ndk\Domain\Traits\LastModifiedFilters;

class OffertoryQuery extends PageQuery
{

    use LastModifiedFilters;

    const SORT_BY_DATE = 'startdate';
    const SORT_BY_NAME = 'name';
    const SORT_BY_PRIORITY = 'priority';

    protected $sort = self::SORT_BY_NAME;

    const FILTER_BY_PRIO_TOP1 = 0;
    const FILTER_BY_PRIO_TOP2 = 1;
    const FILTER_BY_PRIO_A = 2;
    const FILTER_BY_PRIO_B = 3;
    const FILTER_BY_PRIO_C = 4;

    protected $filterProperties = [
        'categories',
        'localization',
        'priority' => 'priorities',
        'id' => 'projects',
        'q' => 'query'
    ];

    /**
     * @var array
     */
    protected $categories = [];

    /**
     * @var array
     */
    protected $localization = [];

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var array
     */
    protected $projects = [];

    /**
     * @var array
     */
    protected $priorities = [];

    /**
     * @return integer[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     * @return OffertoryQuery
     */
    public function setCategories(array $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return array
     */
    public function getLocalization(): array
    {
        return $this->localization;
    }

    /**
     * @param array $localization
     * @return OffertoryQuery
     */
    public function setLocalization(array $localization)
    {
        $this->localization = $localization;

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
     * @return OffertoryQuery
     */
    public function setQuery(string $query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return array
     */
    public function getProjects(): array
    {
        return $this->projects;
    }

    /**
     * @param array $projects
     */
    public function setProjects(array $projects)
    {
        $this->projects = $projects;
    }

    /**
     * @return array
     */
    public function getPriorities(): array
    {
        return $this->priorities;
    }

    /**
     * @param array $priorities
     */
    public function setPriorities(array $priorities)
    {
        $this->priorities = $priorities;
    }
}
