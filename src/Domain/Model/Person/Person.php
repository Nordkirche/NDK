<?php

namespace Nordkirche\Ndk\Domain\Model\Person;

/**
 * @method \Nordkirche\Ndk\Service\Result getDataAdministrators()
 * @method \Nordkirche\Ndk\Service\Result getFunctions()
 * @method \Nordkirche\Ndk\Domain\Model\Address getAddress()
 */
class Person extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
{

    const RELATION_DATA_ADMINISTRATOR = 'data_administrators';
    const RELATION_FUNCTIONS = 'functions';

    const FACET_FUNCTION_TYPE = 'functions';
    const FACET_AVAILABLE_FUNCTION = 'available_functions';

    /**
     * @var string
     */
    protected $birthdayAt;

    /**
     * @var \Nordkirche\Ndk\Service\Result Contains a set of \Nordkirche\Ndk\Domain\Model\ContactItem
     */
    protected $contactItems;

    /**
     * @var string
     */
    protected $job;

    /**
     * @var Name
     */
    protected $name;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\File\Image
     */
    protected $picture;

    /**
     * @var string
     */
    protected $sex;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var \Nordkirche\Ndk\Service\Result with items of \Nordkirche\Ndk\Domain\Model\Person\PersonFunction
     */
    protected $functions;

    /**
     * @var \Nordkirche\Ndk\Service\Result with items of \Nordkirche\Ndk\Domain\Model\Person\Person
     */
    protected $dataAdministrators;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Address
     */
    protected $address;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getName()->getFormatted();
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @param Name $name
     */
    public function setName(Name $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getBirthdayAt(): string
    {
        return $this->birthdayAt;
    }

    /**
     * @param string $birthdayAt
     */
    public function setBirthdayAt(string $birthdayAt)
    {
        $this->birthdayAt = $birthdayAt;
    }

    /**
     * @return null|\Nordkirche\Ndk\Service\Result Returns a set of \Nordkirche\Ndk\Domain\Model\ContactItem
     */
    public function getContactItems()
    {
        return $this->contactItems;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $contactItems
     * @subtype \Nordkirche\Ndk\Domain\Model\ContactItem
     */
    public function setContactItems(\Nordkirche\Ndk\Service\Result $contactItems)
    {
        $this->contactItems = $contactItems;
    }

    /**
     * @return string
     */
    public function getJob(): string
    {
        return $this->job;
    }

    /**
     * @param string $job
     */
    public function setJob(string $job)
    {
        $this->job = $job;
    }

    /**
     * @return null|\Nordkirche\Ndk\Domain\Model\File\Image
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\File\Image $picture
     */
    public function setPicture(\Nordkirche\Ndk\Domain\Model\File\Image $picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return string
     */
    public function getSex(): string
    {
        return $this->sex;
    }

    /**
     * @param string $sex
     */
    public function setSex(string $sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $functions
     * @subtype \Nordkirche\Ndk\Domain\Model\Person\PersonFunction
     */
    public function setFunctions(\Nordkirche\Ndk\Service\Result $functions)
    {
        $this->functions = $functions;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $dataAdministrators
     * @subtype \Nordkirche\Ndk\Domain\Model\Person\Person
     */
    public function setDataAdministrators(\Nordkirche\Ndk\Service\Result $dataAdministrators)
    {
        $this->dataAdministrators = $dataAdministrators;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\Address $address
     */
    public function setAddress(\Nordkirche\Ndk\Domain\Model\Address $address)
    {
        $this->address = $address;
    }
}
