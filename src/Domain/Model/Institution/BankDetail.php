<?php

// Automatically generated at Tue, 16 May 2017 16:38:31 +0000

namespace Nordkirche\Ndk\Domain\Model\Institution;

class BankDetail extends \Nordkirche\Ndk\Domain\Model\AbstractModel
{
            
    /**
     * @var string
     */
    protected $id;
        
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
    public function setId(string $id)
    {
        $this->id = $id;
    }
}
