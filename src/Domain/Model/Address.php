<?php

// Automatically generated at Tue, 16 May 2017 16:38:31 +0000

namespace Nordkirche\Ndk\Domain\Model;

class Address extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
{

    /**
     * @var string
     */
    protected $addition;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $district;

    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    /**
     * @var string
     */
    protected $poBox;

    /**
     * @var string
     */
    protected $poBoxZipCode;

    /**
     * @var string
     */
    protected $street;

    /**
     * @var string
     */
    protected $zipCode;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return implode(', ', array_filter([
            $this->street ?? ($this->poBox ? 'PO ' . $this->poBox : null),
            $this->addition,
            $this->zipCode ?? $this->poBoxZipCode,
            $this->city,
            $this->country
        ]));
    }

    /**
     * @return string
     */
    public function getAddition(): string
    {
        return $this->addition;
    }

    /**
     * @param string $addition
     */
    public function setAddition(string $addition)
    {
        $this->addition = $addition;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getDistrict(): string
    {
        return $this->district;
    }

    /**
     * @param string $district
     */
    public function setDistrict(string $district)
    {
        $this->district = $district;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getPoBox(): string
    {
        return $this->poBox;
    }

    /**
     * @param string $poBox
     */
    public function setPoBox(string $poBox)
    {
        $this->poBox = $poBox;
    }

    /**
     * @return string
     */
    public function getPoBoxZipCode(): string
    {
        return $this->poBoxZipCode;
    }

    /**
     * @param string $poBoxZipCode
     */
    public function setPoBoxZipCode(string $poBoxZipCode)
    {
        $this->poBoxZipCode = $poBoxZipCode;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode)
    {
        $this->zipCode = $zipCode;
    }
}
