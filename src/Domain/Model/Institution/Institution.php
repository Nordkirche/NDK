<?php

namespace Nordkirche\Ndk\Domain\Model\Institution;

use Nordkirche\Ndk\Domain\Model\Address;

/**
 * @method Address getAddress()
 * @method InstitutionType getInstitutionType()
 * @method \Nordkirche\Ndk\Service\Result getMapChildren()
 * @method \Nordkirche\Ndk\Service\Result getCategories()
 * @method \Nordkirche\Ndk\Service\Result getTeams()
 * @method \Nordkirche\Ndk\Service\Result getParentInstitutions()
 * @method \Nordkirche\Ndk\Service\Result getMembers()
 * @method \Nordkirche\Ndk\Service\Result getMemberships()

 */
class Institution extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
{

    const RELATION_MAP_CHILDREN = 'map_children';
    const RELATION_ADDRESS = 'address';
    const RELATION_INSTITUTION_TYPE = 'institution_type';
    const RELATION_PARENT_INSTITUTIONS = 'parent_institutions';
    const RELATION_MEMBERS = 'members';
    const RELATION_MEMBERSHIPS = 'memberships';
    const RELATION_TEAMS = 'teams';

    const FACET_INSTITUTION_TYPE = 'institution_types';

    /**
     * @var string
     */
    protected $abbreviation;

    /**
     * @var array
     */
    protected $availableFunctions;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Institution\BankDetail
     */
    protected $bankDetails;

    /**
     * @var \Nordkirche\Ndk\Service\Result Contains a set of \Nordkirche\Ndk\Domain\Model\ContactItem
     */
    protected $contactItems;

    /**
     * @var \Nordkirche\Ndk\Service\Result Contains a set of \Nordkirche\Ndk\Domain\Model\Institution\Team
     */
    protected $teams;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $infos;

    /**
     * @var boolean
     */
    protected $isAuthorizedCollector;

    /**
     * @var boolean
     */
    protected $isOpenChurch;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\File\Image
     */
    protected $logo;

    /**
     * @var boolean
     */
    protected $mapVisibility;

    /**
     * @var \Nordkirche\Ndk\Service\Result Contains a set of \Nordkirche\Ndk\Domain\Model\File\File
     */
    protected $media;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $officialName;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\File\Image
     */
    protected $picture;

    /**
     * @var string
     */
    protected $tourismKey;

    /**
     * @var string
     */
    protected $vcardLink;

    /**
     * @var integer
     */
    protected $vcardType;

    /**
     * @var integer
     */
    protected $yearOfConstruction;

    /**
     * @var \Nordkirche\Ndk\Service\Result Contains a set of \Nordkirche\Ndk\Domain\Model\Institution\OpeningHours
     */
    protected $openingHours;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Address
     */
    protected $address;

    /**
     * @var \Nordkirche\Ndk\Service\Result containts a set of \Nordkirche\Ndk\Domain\Category
     */
    protected $categories;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Institution\InstitutionType
     */
    protected $institutionType;

    /**
     * @var \Nordkirche\Ndk\Service\Result contains a set of \Nordkirche\Ndk\Domain\Institution\Institution
     */
    protected $mapChildren;

    /**
     * @var \Nordkirche\Ndk\Service\Result contains a set of \Nordkirche\Ndk\Domain\Institution\Institution
     */
    protected $parentInstitutions;

    /**
     * @var \Nordkirche\Ndk\Service\Result contains a set of \Nordkirche\Ndk\Domain\Institution\Institution
     */
    protected $members;

    /**
     * @var \Nordkirche\Ndk\Service\Result contains a set of \Nordkirche\Ndk\Domain\Institution\Institution
     */
    protected $memberships;

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
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     */
    public function setAbbreviation(string $abbreviation)
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * @return array
     */
    public function getAvailableFunctions(): array
    {
        return $this->availableFunctions;
    }

    /**
     * @param array $availableFunctions
     */
    public function setAvailableFunctions(array $availableFunctions)
    {
        $this->availableFunctions = $availableFunctions;
    }

    /**
     * @return \Nordkirche\Ndk\Domain\Model\Institution\BankDetail
     */
    public function getBankDetails(): \Nordkirche\Ndk\Domain\Model\Institution\BankDetail
    {
        return $this->bankDetails;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\Institution\BankDetail $bankDetails
     */
    public function setBankDetails(\Nordkirche\Ndk\Domain\Model\Institution\BankDetail $bankDetails)
    {
        $this->bankDetails = $bankDetails;
    }

    /**
     * @return \Nordkirche\Ndk\Service\Result Returns a set of \Nordkirche\Ndk\Domain\Model\ContactItem
     */
    public function getContactItems(): \Nordkirche\Ndk\Service\Result
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
     * @param \Nordkirche\Ndk\Service\Result $teams
     * @subtype \Nordkirche\Ndk\Domain\Model\Institution\Team
     */
    public function setTeams(\Nordkirche\Ndk\Service\Result $teams)
    {
        $this->teams = $teams;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getInfos(): array
    {
        return $this->infos;
    }

    /**
     * @param array $infos
     */
    public function setInfos(array $infos)
    {
        $this->infos = $infos;
    }

    /**
     * @return boolean
     */
    public function getIsAuthorizedCollector(): bool
    {
        return $this->isAuthorizedCollector;
    }

    /**
     * @param boolean $isAuthorizedCollector
     */
    public function setIsAuthorizedCollector(bool $isAuthorizedCollector)
    {
        $this->isAuthorizedCollector = $isAuthorizedCollector;
    }

    /**
     * @return boolean
     */
    public function getIsOpenChurch(): bool
    {
        return $this->isOpenChurch;
    }

    /**
     * @param boolean $isOpenChurch
     */
    public function setIsOpenChurch(bool $isOpenChurch)
    {
        $this->isOpenChurch = $isOpenChurch;
    }

    /**
     * @return \Nordkirche\Ndk\Domain\Model\File\Image
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\File\Image $logo
     */
    public function setLogo(\Nordkirche\Ndk\Domain\Model\File\Image $logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return boolean
     */
    public function getMapVisibility(): bool
    {
        return $this->mapVisibility;
    }

    /**
     * @param boolean $mapVisibility
     */
    public function setMapVisibility(bool $mapVisibility)
    {
        $this->mapVisibility = $mapVisibility;
    }

    /**
     * @return \Nordkirche\Ndk\Service\Result Returns a set of \Nordkirche\Ndk\Domain\Model\File\File
     */
    public function getMedia(): \Nordkirche\Ndk\Service\Result
    {
        return $this->media;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $media
     * @subtype \Nordkirche\Ndk\Domain\Model\File\File
     */
    public function setMedia(\Nordkirche\Ndk\Service\Result $media)
    {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getOfficialName(): string
    {
        return $this->officialName;
    }

    /**
     * @param string $officialName
     */
    public function setOfficialName(string $officialName)
    {
        $this->officialName = $officialName;
    }

    /**
     * @return \Nordkirche\Ndk\Domain\Model\File\Image
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
    public function getTourismKey(): string
    {
        return $this->tourismKey;
    }

    /**
     * @param string $tourismKey
     */
    public function setTourismKey(string $tourismKey)
    {
        $this->tourismKey = $tourismKey;
    }

    /**
     * @return string
     */
    public function getVcardLink(): string
    {
        return $this->vcardLink;
    }

    /**
     * @param string $vcardLink
     */
    public function setVcardLink(string $vcardLink)
    {
        $this->vcardLink = $vcardLink;
    }

    /**
     * @return integer
     */
    public function getVcardType(): int
    {
        return $this->vcardType;
    }

    /**
     * @param integer $vcardType
     */
    public function setVcardType(int $vcardType)
    {
        $this->vcardType = $vcardType;
    }

    /**
     * @return integer
     */
    public function getYearOfConstruction(): int
    {
        return $this->yearOfConstruction;
    }

    /**
     * @param integer $yearOfConstruction
     */
    public function setYearOfConstruction(int $yearOfConstruction)
    {
        $this->yearOfConstruction = $yearOfConstruction;
    }

    /**
     * @return \Nordkirche\Ndk\Service\Result Returns a set of \Nordkirche\Ndk\Domain\Model\Institution\OpeningHours
     */
    public function getOpeningHours(): \Nordkirche\Ndk\Service\Result
    {
        return $this->openingHours;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $openingHours
     * @subtype \Nordkirche\Ndk\Domain\Model\Institution\OpeningHours

     */
    public function setOpeningHours(\Nordkirche\Ndk\Service\Result $openingHours)
    {
        $this->openingHours = $openingHours;
    }


    /**
     * @param \Nordkirche\Ndk\Domain\Model\Address $address
     */
    public function setAddress(\Nordkirche\Ndk\Domain\Model\Address $address)
    {
        $this->address = $address;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $categories
     * @subtype \Nordkirche\Ndk\Domain\Model\Category
     */
    public function setCategories(\Nordkirche\Ndk\Service\Result $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\Institution\InstitutionType $institutionType
     */
    public function setInstitutionType(\Nordkirche\Ndk\Domain\Model\Institution\InstitutionType $institutionType)
    {
        $this->institutionType = $institutionType;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $mapChildren
     * @subtype \Nordkirche\Ndk\Domain\Institution\Institution
     */
    public function setMapChildren(\Nordkirche\Ndk\Service\Result $mapChildren)
    {
        $this->mapChildren = $mapChildren;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $parentInstitutions
     * @subtype \Nordkirche\Ndk\Domain\Institution\Institution
     */
    public function setParentInstitutions(\Nordkirche\Ndk\Service\Result $parentInstitutions)
    {
        $this->parentInstitutions = $parentInstitutions;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $members
     * @subtype \Nordkirche\Ndk\Domain\Institution\Institution
     */
    public function setMembers(\Nordkirche\Ndk\Service\Result $members)
    {
        $this->members = $members;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $memberships
     * @subtype \Nordkirche\Ndk\Domain\Institution\Institution
     */
    public function setMemberships(\Nordkirche\Ndk\Service\Result $memberships)
    {
        $this->memberships = $memberships;
    }


}
