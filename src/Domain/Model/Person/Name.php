<?php

namespace Nordkirche\Ndk\Domain\Model\Person;

use Nordkirche\Ndk\Domain\Model\AbstractModel;

class Name extends AbstractModel
{
    protected $standardOpening = '';
    protected $salutation = '';
    protected $clericalTitle = '';
    protected $title = '';
    protected $first = '';
    protected $last = '';
    protected $formatted = '';

    /**
     * @return string
     */
    public function getStandardOpening(): string
    {
        return $this->standardOpening;
    }

    /**
     * @param string $standardOpening
     */
    public function setStandardOpening(string $standardOpening)
    {
        $this->standardOpening = $standardOpening;
    }

    /**
     * @return string
     */
    public function getSalutation(): string
    {
        return $this->salutation;
    }

    /**
     * @param string $salutation
     */
    public function setSalutation(string $salutation)
    {
        $this->salutation = $salutation;
    }

    /**
     * @return string
     */
    public function getClericalTitle(): string
    {
        return $this->clericalTitle;
    }

    /**
     * @param string $clericalTitle
     */
    public function setClericalTitle(string $clericalTitle)
    {
        $this->clericalTitle = $clericalTitle;
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
     * @return string
     */
    public function getFirst(): string
    {
        return $this->first;
    }

    /**
     * @param string $first
     */
    public function setFirst(string $first)
    {
        $this->first = $first;
    }

    /**
     * @return string
     */
    public function getLast(): string
    {
        return $this->last;
    }

    /**
     * @param string $last
     */
    public function setLast(string $last)
    {
        $this->last = $last;
    }

    /**
     * @return string
     */
    public function getFormatted(): string
    {
        return $this->formatted;
    }

    /**
     * @param string $formatted
     */
    public function setFormatted(string $formatted)
    {
        $this->formatted = $formatted;
    }
}
