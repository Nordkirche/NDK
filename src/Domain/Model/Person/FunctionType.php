<?php

namespace Nordkirche\Ndk\Domain\Model\Person;

use Nordkirche\Ndk\Domain\Model\AbstractResourceObject;

class FunctionType extends AbstractResourceObject
{
    /**
     * @var string
     */
    protected $title = '';

    public function getLabel(): string
    {
        return $this->getTitle();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}
