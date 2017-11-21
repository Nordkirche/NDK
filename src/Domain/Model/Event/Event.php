<?php

namespace Nordkirche\Ndk\Domain\Model\Event;

use Nordkirche\Ndk\Domain\Model\Address;
use Nordkirche\Ndk\Domain\Model\Category;
use Nordkirche\Ndk\Domain\Model\Institution\Institution;

/**
 * @method Address getAddress()
 * @method Institution getHostInstitution()
 * @method Institution getChiefOrganizer()
 * @method \Nordkirche\Ndk\Service\Result getCategories()
 * @method \Nordkirche\Ndk\Service\Result getOrganizers()
 * @method \Nordkirche\Ndk\Service\Result getParticipants()
 */
class Event extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
{
    const RELATION_ADDRESS = 'address';
    const RELATION_CHIEF_ORGANIZER = 'chief_organizer';

    const FACET_EVENT_TYPE = 'event_types';

    /**
     * @var string
     */
    protected $id;
            
    /**
     * @var string
     */
    protected $alternateLocation;
            
    /**
     * @var array
     */
    protected $choirs;
            
    /**
     * @var array
     */
    protected $compositions;
            
    /**
     * @var string
     */
    protected $description;
            
    /**
     * @var \DateTime
     */
    protected $endsAt;
            
    /**
     * @var array
     */
    protected $ensembles;
            
    /**
     * @var string
     */
    protected $eventType;
            
    /**
     * @var \Nordkirche\Ndk\Service\Result Contains a set of \Nordkirche\Ndk\Domain\Model\File\File
     */
    protected $files;
            
    /**
     * @var string
     */
    protected $hints;
            
    /**
     * @var array
     */
    protected $instrumentalSoloists;
            
    /**
     * @var string
     */
    protected $kicker;
            
    /**
     * @var string
     */
    protected $lead;
            
    /**
     * @var string
     */
    protected $locationName;
            
    /**
     * @var boolean
     */
    protected $numberedSeats;
            
    /**
     * @var array
     */
    protected $orchestras;
            
    /**
     * @var string
     */
    protected $participantsText;
            
    /**
     * @var \Nordkirche\Ndk\Domain\Model\File\Image
     */
    protected $picture;
            
    /**
     * @var array
     */
    protected $price;
            
    /**
     * @var string
     */
    protected $recipientEmail;
            
    /**
     * @var \DateTime
     */
    protected $startsAt;
            
    /**
     * @var array
     */
    protected $tags;
            
    /**
     * @var string
     */
    protected $teaserText;
            
    /**
     * @var string
     */
    protected $textOrganizers;
            
    /**
     * @var array
     */
    protected $ticketSale;
            
    /**
     * @var string
     */
    protected $ticketSaleText;
            
    /**
     * @var string
     */
    protected $title;
            
    /**
     * @var array
     */
    protected $vocalSoloists;
            
    /**
     * @var Address
     */
    protected $address;
            
    /**
     * @var Category
     */
    protected $categories;
            
    /**
     * @var Institution
     */
    protected $chiefOrganizer;
            
    /**
     * @var Institution
     */
    protected $hostInstitution;
            
    /**
     * @var \Nordkirche\Ndk\Service\Result with items of type \Nordkirche\Ndk\Domain\Model\Institution\Institution
     */
    protected $organizers;
            
    /**
     * @var \Nordkirche\Ndk\Service\Result with items of type \Nordkirche\Ndk\Domain\Model\Person\Person
     */
    protected $participants;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getStartsAt()->format('d.m.Y H:i').' - '.$this->getTitle();
    }

    /**
     * @return string
     */
    public function getAlternateLocation(): string
    {
        return $this->alternateLocation;
    }
    
    /**
     * @param string $alternateLocation
     */
    public function setAlternateLocation(string $alternateLocation)
    {
        $this->alternateLocation = $alternateLocation;
    }
        
    /**
     * @return array
     */
    public function getChoirs(): array
    {
        return $this->choirs;
    }
    
    /**
     * @param array $choirs
     */
    public function setChoirs(array $choirs)
    {
        $this->choirs = $choirs;
    }
        
    /**
     * @return array
     */
    public function getCompositions(): array
    {
        return $this->compositions;
    }
    
    /**
     * @param array $compositions
     */
    public function setCompositions(array $compositions)
    {
        $this->compositions = $compositions;
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
     * @return \DateTime
     */
    public function getEndsAt(): \DateTime
    {
        return $this->endsAt;
    }
    
    /**
     * @param string $endsAt
     */
    public function setEndsAt(string $endsAt)
    {
        if ($endsAt) {
            $this->endsAt = new \DateTime($endsAt);
        } else {
            $this->endsAt = $this->startsAt;
        }
    }
        
    /**
     * @return array
     */
    public function getEnsembles(): array
    {
        return $this->ensembles;
    }
    
    /**
     * @param array $ensembles
     */
    public function setEnsembles(array $ensembles)
    {
        $this->ensembles = $ensembles;
    }
        
    /**
     * @return string
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }
    
    /**
     * @param string $eventType
     */
    public function setEventType(string $eventType)
    {
        $this->eventType = $eventType;
    }
        
    /**
     * @return \Nordkirche\Ndk\Service\Result Returns a set of \Nordkirche\Ndk\Domain\Model\File\File
     */
    public function getFiles(): \Nordkirche\Ndk\Service\Result
    {
        return $this->files;
    }
    
    /**
     * @param \Nordkirche\Ndk\Service\Result $files
     * @subtype \Nordkirche\Ndk\Domain\Model\File\File
     */
    public function setFiles(\Nordkirche\Ndk\Service\Result $files)
    {
        $this->files = $files;
    }
        
    /**
     * @return string
     */
    public function getHints(): string
    {
        return $this->hints;
    }
    
    /**
     * @param string $hints
     */
    public function setHints(string $hints)
    {
        $this->hints = $hints;
    }
        
    /**
     * @return array
     */
    public function getInstrumentalSoloists(): array
    {
        return $this->instrumentalSoloists;
    }
    
    /**
     * @param array $instrumentalSoloists
     */
    public function setInstrumentalSoloists(array $instrumentalSoloists)
    {
        $this->instrumentalSoloists = $instrumentalSoloists;
    }
        
    /**
     * @return string
     */
    public function getKicker(): string
    {
        return $this->kicker;
    }
    
    /**
     * @param string $kicker
     */
    public function setKicker(string $kicker)
    {
        $this->kicker = $kicker;
    }
        
    /**
     * @return string
     */
    public function getLead(): string
    {
        return $this->lead;
    }
    
    /**
     * @param string $lead
     */
    public function setLead(string $lead)
    {
        $this->lead = $lead;
    }
        
    /**
     * @return string
     */
    public function getLocationName(): string
    {
        return $this->locationName;
    }
    
    /**
     * @param string $locationName
     */
    public function setLocationName(string $locationName)
    {
        $this->locationName = $locationName;
    }
        
    /**
     * @return boolean
     */
    public function getNumberedSeats(): bool
    {
        return $this->numberedSeats;
    }
    
    /**
     * @param boolean $numberedSeats
     */
    public function setNumberedSeats(bool $numberedSeats)
    {
        $this->numberedSeats = $numberedSeats;
    }
        
    /**
     * @return array
     */
    public function getOrchestras(): array
    {
        return $this->orchestras;
    }
    
    /**
     * @param array $orchestras
     */
    public function setOrchestras(array $orchestras)
    {
        $this->orchestras = $orchestras;
    }
        
    /**
     * @return string
     */
    public function getParticipantsText(): string
    {
        return $this->participantsText;
    }
    
    /**
     * @param string $participantsText
     */
    public function setParticipantsText(string $participantsText)
    {
        $this->participantsText = $participantsText;
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
     * @return array
     */
    public function getPrice(): array
    {
        return $this->price;
    }
    
    /**
     * @param array $price
     */
    public function setPrice(array $price)
    {
        $this->price = $price;
    }
        
    /**
     * @return string
     */
    public function getRecipientEmail(): string
    {
        return $this->recipientEmail;
    }
    
    /**
     * @param string $recipientEmail
     */
    public function setRecipientEmail(string $recipientEmail)
    {
        $this->recipientEmail = $recipientEmail;
    }
        
    /**
     * @return \DateTime
     */
    public function getStartsAt(): \DateTime
    {
        return $this->startsAt;
    }
    
    /**
     * @param string $startsAt
     */
    public function setStartsAt(string $startsAt)
    {
        $this->startsAt = new \DateTime($startsAt);
    }
        
    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }
    
    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }
        
    /**
     * @return string
     */
    public function getTeaserText(): string
    {
        return $this->teaserText;
    }
    
    /**
     * @param string $teaserText
     */
    public function setTeaserText(string $teaserText)
    {
        $this->teaserText = $teaserText;
    }
        
    /**
     * @return string
     */
    public function getTextOrganizers(): string
    {
        return $this->textOrganizers;
    }
    
    /**
     * @param string $textOrganizers
     */
    public function setTextOrganizers(string $textOrganizers)
    {
        $this->textOrganizers = $textOrganizers;
    }
        
    /**
     * @return array
     */
    public function getTicketSale(): array
    {
        return $this->ticketSale;
    }
    
    /**
     * @param array $ticketSale
     */
    public function setTicketSale(array $ticketSale)
    {
        $this->ticketSale = $ticketSale;
    }
        
    /**
     * @return string
     */
    public function getTicketSaleText(): string
    {
        return $this->ticketSaleText;
    }
    
    /**
     * @param string $ticketSaleText
     */
    public function setTicketSaleText(string $ticketSaleText)
    {
        $this->ticketSaleText = $ticketSaleText;
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
    public function getVocalSoloists(): array
    {
        return $this->vocalSoloists;
    }
    
    /**
     * @param array $vocalSoloists
     */
    public function setVocalSoloists(array $vocalSoloists)
    {
        $this->vocalSoloists = $vocalSoloists;
    }

    
    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }
    
    /**
     * @param Category $categories
     */
    public function setCategories(Category $categories)
    {
        $this->categories = $categories;
    }
    
    /**
     * @param Institution $chiefOrganizer
     */
    public function setChiefOrganizer(Institution $chiefOrganizer)
    {
        $this->chiefOrganizer = $chiefOrganizer;
    }

    
    /**
     * @param Institution $hostInstitution
     */
    public function setHostInstitution(Institution $hostInstitution)
    {
        $this->hostInstitution = $hostInstitution;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $organizers
     */
    public function setOrganizers(\Nordkirche\Ndk\Service\Result $organizers)
    {
        $this->organizers = $organizers;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result $participants
     */
    public function setParticipants(\Nordkirche\Ndk\Service\Result $participants)
    {
        $this->participants = $participants;
    }
}
