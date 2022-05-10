<?php

namespace Nordkirche\Ndk\Domain\Model\Event;

use Nordkirche\Ndk\Domain\Model\Address;

/**
 * @method \Nordkirche\Ndk\Domain\Model\Address getAddress()
 */
class EventLocation extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject {

    /**
     * @var string
     */
    protected $name ;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Address
     */
    protected $address;

    /**
     * @var \Nordkirche\Ndk\Service\Result Contains a set of \Nordkirche\Ndk\Domain\Model\ContactItem
     */
    protected $contactItems;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        $label = $this->getName();

        if ($address = $this->getAddress()) {
            $label .= ' ' . $address->getLabel();
        }

        return trim($label) ? $label : 'Kein Name';

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
     * @param \Nordkirche\Ndk\Domain\Model\Address $address
     */
    public function setAddress(\Nordkirche\Ndk\Domain\Model\Address $address)
    {
        $this->address = $address;
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

}