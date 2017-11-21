<?php

namespace Nordkirche\Ndk\Domain\Model;

class MetaData extends AbstractModel
{

    /**
     * @var array
     */
    protected $metaData;

    /**
     * @param mixed $metaData
     */
    public function setMetaData(array $metaData)
    {
        $this->metaData = $metaData;
    }

    /**
     * If your request has been a search, you can ask for the relevance of object
     * @returns float|null
     */
    public function getScore()
    {
        if (isset($this->metaData['score'])) {
            return $this->metaData['score'];
        }

        return null;
    }
}
