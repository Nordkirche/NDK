<?php

namespace Nordkirche\Ndk\Domain\Model\Offertory;

/**
 * @method \Nordkirche\Ndk\Domain\Model\Person\Person getPersons()
 * @method \Nordkirche\Ndk\Domain\Model\Institution\Institution getInstitution()
 * @method \Nordkirche\Ndk\Service\Result getCategories()
 */
class Offertory extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
{
    const RELATION_PERSON = 'person';
    const RELATION_INSTITUTION = 'institution';
    const RELATION_CATEGORIES = 'categories';

    const PRIO_TOP1 = 0;
    const PRIO_TOP2 = 1;
    const PRIO_A = 2;
    const PRIO_B = 3;
    const PRIO_C = 4;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $localization;

    /**
     * @var string
     */
    protected $priority;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\File\Image
     */
    protected $headImage;

    /**
     * @var \Nordkirche\Ndk\Service\Result Contains a set of \Nordkirche\Ndk\Domain\Model\File\Image
     */
    protected $images;

    /**
     * @var string
     */
    protected $video;

    /**
     * @var string
     */
    protected $reason;

    /**
     * @var string
     */
    protected $shortDescription;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var float
     */
    protected $priorProfit;

    /**
     * @var string
     */
    protected $intercession;

    /**
     * @var string
     */
    protected $discontinuation;

    /**
     * @var \Nordkirche\Ndk\Service\Result Contains a set of \Nordkirche\Ndk\Domain\Model\File\File
     */
    protected $exemptions;

    /**
     * @var \DateTime
     */
    protected $starttime;

    /**
     * @var \DateTime
     */
    protected $endtime;

    /**
     * @var string
     */
    protected $altrujaUsage;

    /**
     * @var int
     */
    protected $donationProposal;

    /**
     * @var string
     */
    protected $projectAccountBic;

    /**
     * @var string
     */
    protected $projectAccountHolder;

    /**
     * @var string
     */
    protected $projectAccountNumber;

    /**
     * @var string
     */
    protected $projectAccountIban;

    /**
     * @var string
     */
    protected $projectBankCode;

    /**
     * @var string
     */
    protected $projectBankName;

    /**
     * @var string
     */
    protected $projectAccountUsage;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Person\Person
     */
    protected $person;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Institution\Institution
     */
    protected $institution;

    /**
     * @var \Nordkirche\Ndk\Service\Result containts a set of \Nordkirche\Ndk\Domain\CategoryModel
     */
    protected $categories;


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
     * @return int
     */
    public function getLocalization()
    {
        return $this->localization;
    }

    /**
     * @param int $localization
     */
    public function setLocalization(int $localization)
    {
        $this->localization = $localization;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     */
    public function setPriority(string $priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return \Nordkirche\Ndk\Domain\Model\File\Image
     */
    public function getHeadImage()
    {
        return $this->headImage;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\File\Image $headImage
     */
    public function setHeadImage(\Nordkirche\Ndk\Domain\Model\File\Image $headImage)
    {
        $this->headImage = $headImage;
    }

    /**
     * @return \Nordkirche\Ndk\Service\Result
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $images
     * @subtype \Nordkirche\Ndk\Domain\Model\File\Image
     */
    public function setImages(\Nordkirche\Ndk\Service\Result $images)
    {
        $this->images = $images;
    }

    /**
     * @return string
     */
    public function getVideo(): string
    {
        return $this->video;
    }

    /**
     * @param string $video
     */
    public function setVideo(string $video)
    {
        $this->video = $video;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason(string $reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription(string $shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return float
     */
    public function getPriorProfit(): float
    {
        return $this->priorProfit;
    }

    /**
     * @param float $priorProfit
     */
    public function setPriorProfit(float $priorProfit)
    {
        $this->priorProfit = $priorProfit;
    }

    /**
     * @return string
     */
    public function getIntercession(): string
    {
        return $this->intercession;
    }

    /**
     * @param string $intercession
     */
    public function setIntercession(string $intercession)
    {
        $this->intercession = $intercession;
    }

    /**
     * @return string
     */
    public function getDiscontinuation(): string
    {
        return $this->discontinuation;
    }

    /**
     * @param string $discontinuation
     */
    public function setDiscontinuation(string $discontinuation)
    {
        $this->discontinuation = $discontinuation;
    }

    /**
     * @return \Nordkirche\Ndk\Service\Result
     */
    public function getExemptions()
    {
        return $this->exemptions;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $exemptions
     * @subtype \Nordkirche\Ndk\Domain\Model\File\File
     */
    public function setExemptions(\Nordkirche\Ndk\Service\Result $exemptions)
    {
        $this->exemptions = $exemptions;
    }

    /**
     * @return \DateTime
     */
    public function getStarttime(): \DateTime
    {
        return $this->starttime;
    }

    /**
     * @param string $starttime
     */
    public function setStarttime(string $starttime)
    {
        if ($starttime) {
            $this->starttime = new \DateTime($starttime);
        } else {
            $this->starttime = new \DateTime();
        }
    }

    /**
     * @return \DateTime
     */
    public function getEndtime(): \DateTime
    {
        return $this->endtime;
    }

    /**
     * @param string $endtime
     */
    public function setEndtime(string $endtime)
    {
        if ($endtime) {
            $this->endtime = new \DateTime($endtime);
        } else {
            $this->endtime = $this->starttime;
        }
    }

    /**
     * @return string
     */
    public function getAltrujaUsage(): string
    {
        return $this->altrujaUsage;
    }

    /**
     * @param string $altrujaUsage
     */
    public function setAltrujaUsage(string $altrujaUsage)
    {
        $this->altrujaUsage = $altrujaUsage;
    }

    /**
     * @return int
     */
    public function getDonationProposal(): int
    {
        return $this->donationProposal;
    }

    /**
     * @param int $donationProposal
     */
    public function setDonationProposal(int $donationProposal)
    {
        $this->donationProposal = $donationProposal;
    }

    /**
     * @return string
     */
    public function getProjectAccountBic(): string
    {
        return $this->projectAccountBic;
    }

    /**
     * @param string $projectAccountBic
     */
    public function setProjectAccountBic(string $projectAccountBic)
    {
        $this->projectAccountBic = $projectAccountBic;
    }

    /**
     * @return string
     */
    public function getProjectAccountHolder(): string
    {
        return $this->projectAccountHolder;
    }

    /**
     * @param string $projectAccountHolder
     */
    public function setProjectAccountHolder(string $projectAccountHolder)
    {
        $this->projectAccountHolder = $projectAccountHolder;
    }

    /**
     * @return string
     */
    public function getProjectAccountNumber(): string
    {
        return $this->projectAccountNumber;
    }

    /**
     * @param string $projectAccountNumber
     */
    public function setProjectAccountNumber(string $projectAccountNumber)
    {
        $this->projectAccountNumber = $projectAccountNumber;
    }

    /**
     * @return string
     */
    public function getProjectAccountIban(): string
    {
        return $this->projectAccountIban;
    }

    /**
     * @param string $projectAccountIban
     */
    public function setProjectAccountIban(string $projectAccountIban)
    {
        $this->projectAccountIban = $projectAccountIban;
    }

    /**
     * @return string
     */
    public function getProjectAccountUsage()
    {
        return $this->projectAccountUsage;
    }

    /**
     * @param string $projectAccountUsage
     */
    public function setProjectAccountUsage(string $projectAccountUsage)
    {
        $this->projectAccountUsage = $projectAccountUsage;
    }

    /**
     * @return string
     */
    public function getProjectBankCode(): string
    {
        return $this->projectBankCode;
    }

    /**
     * @param string $projectBankCode
     */
    public function setProjectBankCode(string $projectBankCode)
    {
        $this->projectBankCode = $projectBankCode;
    }

    /**
     * @return string
     */
    public function getProjectBankName(): string
    {
        return $this->projectBankName;
    }

    /**
     * @param string $projectBankName
     */
    public function setProjectBankName(string $projectBankName)
    {
        $this->projectBankName = $projectBankName;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\Person\Person $person
     */
    public function setPerson(\Nordkirche\Ndk\Domain\Model\Person\Person $person)
    {
        $this->person = $person;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\Institution\Institution $institution
     */
    public function setInstitution(\Nordkirche\Ndk\Domain\Model\Institution\Institution $institution)
    {
        $this->institution = $institution;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $categories
     * @subtype \Nordkirche\Ndk\Domain\Model\Category
     */
    public function setCategories(\Nordkirche\Ndk\Service\Result $categories)
    {
        $this->categories = $categories;
    }
}
