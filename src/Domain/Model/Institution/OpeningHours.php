<?php

namespace Nordkirche\Ndk\Domain\Model\Institution;

class OpeningHours extends \Nordkirche\Ndk\Domain\Model\AbstractModel
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var int
     */
    protected $dayOfWeek = 0;

    /**
     * @var string
     */
    protected $openingTime = '';

    /**
     * @var string
     */
    protected $closingTime = '';

    /**
     * @var string
     */
    protected $date = '';

    /**
     * @var bool
     */
    protected $closed = false;

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
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getDayOfWeek(): int
    {
        return $this->dayOfWeek;
    }

    /**
     * @param int $dayOfWeek
     */
    public function setDayOfWeek(int $dayOfWeek): void
    {
        $this->dayOfWeek = $dayOfWeek;
    }

    /**
     * @return string
     */
    public function getOpeningTime(): string
    {
        return $this->openingTime;
    }

    /**
     * @param string $openingTime
     */
    public function setOpeningTime(string $openingTime): void
    {
        $this->openingTime = $openingTime;
    }

    /**
     * @return string
     */
    public function getClosingTime(): string
    {
        return $this->closingTime;
    }

    /**
     * @param string $closingTime
     */
    public function setClosingTime(string $closingTime): void
    {
        $this->closingTime = $closingTime;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }
    
    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->closed;
    }

    /**
     * @param bool $closed
     */
    public function setClosed(bool $closed): void
    {
        $this->closed = $closed;
    }
}
