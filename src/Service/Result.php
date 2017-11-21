<?php

namespace Nordkirche\Ndk\Service;

class Result implements \Countable, \Iterator
{
    /**
     * @var int
     */
    protected $pageCount = 0;

    /**
     * @var int
     */
    protected $recordCount = 0;

    /**
     * @var array
     */
    protected $facets = [];

    /**
     * @var \SplObjectStorage
     */
    protected $objects;

    /**
     * Collection constructor.
     *
     * @param \SplObjectStorage $records
     * @param int $pageCount
     * @param int $recordCount
     * @param array $facets
     */
    public function __construct(\SplObjectStorage $records, int $pageCount, int $recordCount, array $facets = [])
    {
        $this->objects = $records;
        $this->pageCount = $pageCount;
        $this->recordCount = $recordCount;
        $this->facets = $facets;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getObjects(): \SplObjectStorage
    {
        return $this->objects;
    }

    /**
     * @return int
     */
    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    /**
     * @return int
     */
    public function getRecordCount(): int
    {
        return $this->recordCount;
    }

    /**
     * @return array
     */
    public function getFacets(): array
    {
        return $this->facets;
    }

    public function current()
    {
        return $this->objects->current();
    }

    public function next()
    {
        $this->objects->next();
    }

    public function key()
    {
        return $this->objects->key();
    }

    public function valid()
    {
        return $this->objects->valid();
    }

    public function rewind()
    {
        $this->objects->rewind();
    }

    public function count()
    {
        return $this->objects->count();
    }
}
