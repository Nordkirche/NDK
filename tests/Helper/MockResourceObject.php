<?php

namespace Nordkirche\Ndk\Helper;

class MockResourceObject implements \Nordkirche\Ndk\Service\Interfaces\ResourceObjectInterface
{

    public $id = 777;

    public $type = 'mockresources';

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type)
    {
    }

    public function __toString()
    {
    }
}