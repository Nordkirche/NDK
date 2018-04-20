<?php

namespace Nordkirche\Ndk\Domain\Traits;

/**
 * Can be used on QueryObjects to add filters based on the last modification date of a resource
 * @property $filterProperties array
 */
trait LastModifiedFilters
{

    /**
     * @var \DateTime
     */
    protected $modifiedBefore;

    /**
     * @var \DateTime
     */
    protected $modifiedAfter;

    /**
     * @return \DateTime
     */
    public function getModifiedBefore(): \DateTime
    {
        return $this->modifiedBefore;
    }

    /**
     * @param \DateTime $modifiedBefore
     *
     * @return self
     */
    public function setModifiedBefore(\DateTime $modifiedBefore)
    {
        $this->addLastModifiedFilter('modifiedBefore');
        $this->modifiedBefore = $modifiedBefore;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedAfter(): \DateTime
    {
        return $this->modifiedAfter;
    }

    /**
     * @param \DateTime $modifiedAfter
     *
     * @return self
     */
    public function setModifiedAfter(\DateTime $modifiedAfter)
    {
        $this->addLastModifiedFilter('modifiedAfter');
        $this->modifiedAfter = $modifiedAfter;

        return $this;
    }

    private function addLastModifiedFilter($name)
    {
        if (!in_array($name, $this->filterProperties)) {
            $this->filterProperties[] = $name;
        }
    }
}
