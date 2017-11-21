<?php

// Automatically generated at Tue, 16 May 2017 16:38:31 +0000

namespace Nordkirche\Ndk\Domain\Model\Institution;

class InstitutionType extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
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
