<?php
namespace Nordkirche\Ndk\Domain\Model\Person;

/**
 * @method \Nordkirche\Ndk\Domain\Model\Institution\Institution getInstitution()
 * @method \Nordkirche\Ndk\Domain\Model\Person\Person getPerson()
 * @method FunctionType getFunctionType()
 * @method AvailableFunction getAvailableFunction()
 * @method \Nordkirche\Ndk\Domain\Model\Address getAddress()
 */
class PersonFunction extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
{

    const RELATION_PERSON = 'person';
    const RELATION_INSTITUTION = 'institution';
    const RELATION_ADDRESS = 'address';
    const RELATION_FUNCTION_TYPE = 'function_type';
    const RELATION_AVAILABLE_FUNCTION = 'available_function';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var array
     */
    protected $contactItems = [];

    /**
     * @var string
     */
    protected $responsibilities = '';

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Institution\Institution
     */
    protected $institution;
            
    /**
     * @var \Nordkirche\Ndk\Domain\Model\Person\Person
     */
    protected $person;

    /**
     * @var FunctionType
     */
    protected $functionType;

    /**
     * @var AvailableFunction
     */
    protected $availableFunction;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Address
     */
    protected $address;

    /**
     * @return string
     */
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

    /**
     * @return array
     */
    public function getContactItems(): array
    {
        return $this->contactItems;
    }

    /**
     * @param array $contactItems
     */
    public function setContactItems(array $contactItems)
    {
        $this->contactItems = $contactItems;
    }

    /**
     * @return string
     */
    public function getResponsibilities(): string
    {
        return $this->responsibilities;
    }

    /**
     * @param string $responsibilities
     */
    public function setResponsibilities(string $responsibilities)
    {
        $this->responsibilities = $responsibilities;
    }


    /**
     * @param \Nordkirche\Ndk\Domain\Model\Institution\Institution $institution
     */
    public function setInstitution(\Nordkirche\Ndk\Domain\Model\Institution\Institution $institution)
    {
        $this->institution = $institution;
    }
    
    /**
     * @param \Nordkirche\Ndk\Domain\Model\Person\Person $person
     */
    public function setPerson(\Nordkirche\Ndk\Domain\Model\Person\Person $person)
    {
        $this->person = $person;
    }

    /**
     * @param FunctionType $functionType
     */
    public function setFunctionType(FunctionType $functionType)
    {
        $this->functionType = $functionType;
    }

    /**
     * @param AvailableFunction $availableFunction
     */
    public function setAvailableFunction(AvailableFunction $availableFunction)
    {
        $this->availableFunction = $availableFunction;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\Address $address
     */
    public function setAddress(\Nordkirche\Ndk\Domain\Model\Address $address)
    {
        $this->address = $address;
    }
}
