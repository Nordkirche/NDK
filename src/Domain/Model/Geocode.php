<?php

namespace Nordkirche\Ndk\Domain\Model;

class Geocode implements \Nordkirche\Ndk\Domain\Interfaces\QueryParameterValue
{

    private $latitude;

    private $longitude;

    private $radius;

    public function __construct(float $latitude, float $longitude, int $radius = 0)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->radius = $radius;
    }

    public function returnParameterValue(): string
    {
        return implode(',', [$this->getLatitude(), $this->getLongitude(), $this->getRadius()]);
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function getRadius(): int
    {
        return $this->radius;
    }
}
