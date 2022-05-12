<?php

namespace Nordkirche\Ndk\Domain\Model\Event;

class TargetGroup extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getName();
    }
}
