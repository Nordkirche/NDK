<?php

namespace Nordkirche\Ndk\Domain\Query;

use Nordkirche\Ndk\Domain\Model\Geocode;
use Nordkirche\Ndk\Domain\Traits\LastModifiedFilters;

class EventQuery extends PageQuery
{

    use LastModifiedFilters;

    const SORT_BY_TIME_FROM = 'time_from';

    protected $sort = PageQuery::SORT_ASC . self::SORT_BY_TIME_FROM;

    protected $filterProperties = [
        'id' => 'events',
        'categories' => 'categoriesOr',
        '+categories' => 'categoriesAnd',
        'chiefOrganizer',
        'eventType',
        'cities',
        'plz' => 'zipCodes',
        'churchAssociations',
        'geocode',
        'location',
        'organizers',
        'organizersWithParents',
        'targetGroups',
        'timeFrom',
        'timeFromStart',
        'timeTo',
        'timeToEnd',
        'q' => 'query'
    ];

    /**
     * @var array
     */
    protected $events = [];

    /**
     * @var integer[]
     */
    protected $categoriesOr = [];

    /**
     * var integer[]
     */
    protected $categoriesAnd = [];

    /**
     * @var string
     */
    protected $chiefOrganizer = '';

    /**
     * @var string
     */
    protected $eventType = '';

    /**
     * @var integer[]
     */
    protected $zipCodes = [];

    /**
     * @var string[]
     */
    protected $cities = [];

    /**
     * @var integer[]
     */
    protected $churchAssociations = [];

    /**
     * @var Geocode
     */
    protected $geocode = null;

    /**
     * @var string
     */
    protected $location = '';

    /**
     * @var integer[]
     */
    protected $organizers = [];

    /**
     * @var integer[]
     */
    protected $organizersWithParents = [];

    /**
     * @var integer[]
     */
    protected $targetGroups = [];

    /**
     * @var \DateTime
     */
    protected $timeFrom = null;

    /**
     * @var \DateTime
     */
    protected $timeFromStart = null;

    /**
     * @var \DateTime
     */
    protected $timeTo = null;

    /**
     * @var \DateTime
     */
    protected $timeToEnd = null;

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @return array
     */
    public function getFilterProperties(): array
    {
        return $this->filterProperties;
    }

    /**
     * @param array $filterProperties
     *
     * @return EventQuery
     */
    public function setFilterProperties(array $filterProperties): EventQuery
    {
        $this->filterProperties = $filterProperties;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @param integer[] $events
     */
    public function setEvents(array $events)
    {
        $this->events = $events;
    }

    /**
     * @return integer[]
     */
    public function getCategoriesOr(): array
    {
        return $this->categoriesOr;
    }

    /**
     * @param integer[] $categories
     *
     * @return EventQuery
     */
    public function setCategoriesOr(array $categories): EventQuery
    {
        $this->categoriesOr = $categories;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getCategoriesAnd(): array
    {
        return $this->categoriesAnd;
    }

    /**
     * @param array $categories
     *
     * @return EventQuery
     */
    public function setCategoriesAnd(array $categories): EventQuery
    {
        $this->categoriesAnd = $categories;

        return $this;
    }

    /**
     * @return string
     */
    public function getChiefOrganizer(): string
    {
        return $this->chiefOrganizer;
    }

    /**
     * @param string $chiefOrganizer
     *
     * @return EventQuery
     */
    public function setChiefOrganizer(string $chiefOrganizer): EventQuery
    {
        $this->chiefOrganizer = $chiefOrganizer;

        return $this;
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
     *
     * @return EventQuery
     */
    public function setEventType(string $eventType): EventQuery
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getZipCodes(): array
    {
        return $this->zipCodes;
    }

    /**
     * @param integer[] $zipCodes
     *
     * @return EventQuery
     */
    public function setZipCodes(array $zipCodes): EventQuery
    {
        $this->zipCodes = $zipCodes;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getCities(): array
    {
        return $this->cities;
    }

    /**
     * @param \string[] $cities
     *
     * @return EventQuery
     */
    public function setCities(array $cities): EventQuery
    {
        $this->cities = $cities;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getChurchAssociations(): array
    {
        return $this->churchAssociations;
    }

    /**
     * @param integer[] $churchAssociations
     *
     * @return EventQuery
     */
    public function setChurchAssociations(array $churchAssociations): EventQuery
    {
        $this->churchAssociations = $churchAssociations;

        return $this;
    }

    /**
     * @return Geocode
     */
    public function getGeocode(): Geocode
    {
        return $this->geocode;
    }

    /**
     * @param Geocode $geocode
     *
     * @return EventQuery
     */
    public function setGeocode(Geocode $geocode): EventQuery
    {
        $this->geocode = $geocode;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     *
     * @return EventQuery
     */
    public function setLocation(string $location): EventQuery
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getOrganizers(): array
    {
        return $this->organizers;
    }

    /**
     * @param integer[] $organizers
     *
     * @return EventQuery
     */
    public function setOrganizers(array $organizers): EventQuery
    {
        $this->organizers = $organizers;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getTargetGroups(): array
    {
        return $this->targetGroups;
    }

    /**
     * @param integer[] $targetGroups
     */
    public function setTargetGroups($targetGroups): EventQuery
    {
        $this->targetGroups = $targetGroups;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimeFrom(): \DateTime
    {
        return $this->timeFrom;
    }

    /**
     * @param \DateTime $timeFrom
     *
     * @return EventQuery
     */
    public function setTimeFrom(\DateTime $timeFrom): EventQuery
    {
        $this->timeFrom = $timeFrom;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimeFromStart(): \DateTime
    {
        return $this->timeFromStart;
    }

    /**
     * @param \DateTime $timeFromStart
     *
     * @return EventQuery
     */
    public function setTimeFromStart(\DateTime $timeFromStart)
    {
        $this->timeFromStart = $timeFromStart;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimeTo(): \DateTime
    {
        return $this->timeTo;
    }

    /**
     * @param \DateTime $timeTo
     *
     * @return EventQuery
     */
    public function setTimeTo(\DateTime $timeTo): EventQuery
    {
        $this->timeTo = $timeTo;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimeToEnd(): \DateTime
    {
        return $this->timeToEnd;
    }

    /**
     * @param \DateTime $timeToEnd
     *
     * @return EventQuery
     */
    public function setTimeToEnd(\DateTime $timeToEnd)
    {
        $this->timeToEnd = $timeToEnd;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     *
     * @return EventQuery
     */
    public function setQuery(string $query): EventQuery
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getOrganizersWithParents(): array
    {
        return $this->organizersWithParents;
    }

    /**
     * @param integer[] $organizersWithParents
     *
     * @return EventQuery
     */
    public function setOrganizersWithParents(array $organizersWithParents): EventQuery
    {
        $this->organizersWithParents = $organizersWithParents;

        return $this;
    }
}
