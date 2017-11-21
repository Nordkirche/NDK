<?php

// Automatically generated at Tue, 16 May 2017 16:38:31 +0000

namespace Nordkirche\Ndk\Domain\Model;

class ContactItem extends \Nordkirche\Ndk\Domain\Model\AbstractModel
{
    /**
     * Readable type
     * @var string
     */
    protected $type = '';

    /**
     * @var string
     */
    protected $value = '';

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }
}
