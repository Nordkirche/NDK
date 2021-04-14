<?php

// Automatically generated at Fri, 10 Mar 2017 16:43:08 +0000

namespace Nordkirche\Ndk\Domain\Model;

/**
 * @method Category getParent()
 */
class Category extends AbstractResourceObject
{

    /**
     * @var string
     */
    protected $name;
            
    /**
     * @var bool
     */
    protected $isChurchAssociation;
            
    /**
     * @var Category
     */
    protected $parent;

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
        
    /**
     * @return bool
     */
    public function getIsChurchAssociation(): bool
    {
        return $this->isChurchAssociation;
    }
    
    /**
     * @param bool $churchAssociation
     */
    public function setIsChurchAssociation(bool $isChurchAssociation)
    {
        $this->isChurchAssociation = $isChurchAssociation;
    }
    
    /**
     * @param Category $parent
     */
    public function setParent(Category $parent)
    {
        $this->parent = $parent;
    }

}
