<?php

namespace Nordkirche\Ndk\Domain\Query;

class PageQuery extends AbstractQuery
{

    const SORT_ASC = '';
    const SORT_DESC = '-';

    /**
     * @var int
     */
    protected $pageSize;

    /**
     * @var int
     */
    protected $pageNumber;

    /**
     * @var string
     */
    protected $sort;

    /**
     * AbstractFilter constructor.
     *
     * @param int $pageNumber
     * @param int $pageSize
     */
    public function __construct($pageNumber = 1, $pageSize = 10)
    {
        if ($pageSize > 500) {
            throw new \InvalidArgumentException(
                'Page size is not allowed to exceed 500. Given: ' . $pageSize,
                1494952031
            );
        }
        $this->pageSize = $pageSize;
        $this->pageNumber = $pageNumber;

        return $this;
    }

    public function returnUrlParameters(): array
    {
        $parameters = parent::returnUrlParameters();
        $parameters['page'] = ['number' => $this->pageNumber, 'size' => $this->pageSize];
        if ($this->sort) {
            $parameters['sort'] = $this->sort;
        }

        return $parameters;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @param int $pageSize
     *
     * @return AbstractQuery
     */
    public function setPageSize(int $pageSize): AbstractQuery
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * @param int $pageNumber
     *
     * @return AbstractQuery
     */
    public function setPageNumber(int $pageNumber): AbstractQuery
    {
        $this->pageNumber = $pageNumber;

        return $this;
    }

    /**
     * @param string $sort Use a SomeQueryObject::SORT_BY_* to set field to sort by
     * @param string $direction Use PageQuery::SORT_* to set sorting direction
     *
     * @return PageQuery
     */
    public function setSort(string $sort, string $direction = self::SORT_ASC): PageQuery
    {
        $this->sort = $direction . $sort;

        return $this;
    }
}
