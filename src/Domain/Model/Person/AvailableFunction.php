<?php

namespace Nordkirche\Ndk\Domain\Model\Person;

use Nordkirche\Ndk\Domain\Model\AbstractResourceObject;

class AvailableFunction extends AbstractResourceObject
{
    /**
     * @var string
     */
    protected $name = '';

    public function getLabel(): string
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}
