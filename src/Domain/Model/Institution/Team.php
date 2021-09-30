<?php

namespace Nordkirche\Ndk\Domain\Model\Institution;

/**
 * @method Institution getInstitution()
 * @method FunctionType getFunctionType()
 * @method \Nordkirche\Ndk\Service\Result getFunctions()
 */
class Team extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
{
    const RELATION_INSTITUTION = 'institution';
    const RELATION_FUNCTION_TYPE = 'function_type';
    const RELATION_FUNCTIONS = 'functions';

    /**
     * @var string
     */
    protected $team = '';

    /**
     * @var bool
     */
    protected $highlight = false;

    /**
     * @var bool
     */
    protected $showExpanded = false;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Institution\Institution
     */
    protected $institution;

    /**
     * @var \Nordkirche\Ndk\Domain\Model\Person\FunctionType
     */
    protected $functionType;

    /**
     * @var \Nordkirche\Ndk\Service\Result Contains a set of \Nordkirche\Ndk\Domain\Model\Person\PersonFunction
     */
    protected $functions;


    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getTeam();
    }

    /**
     * @return string
     */
    public function getTeam(): string
    {
        return $this->team;
    }

    /**
     * @param string $team
     */
    public function setTeam(string $team): void
    {
        $this->team = $team;
    }

    /**
     * @return bool
     */
    public function getHighlight(): bool
    {
        return $this->highlight;
    }

    /**
     * @param bool $highlight
     */
    public function setHighlight(bool $highlight)
    {
        $this->highlight = $highlight;
    }

    /**
     * @return bool
     */
    public function getShowExpanded(): bool
    {
        return $this->showExpanded;
    }

    /**
     * @param bool $showExpanded
     */
    public function setShowExpanded(bool $showExpanded)
    {
        $this->showExpanded = $showExpanded;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\Institution\Institution
     */
    public function setInstitution(\Nordkirche\Ndk\Domain\Institution\Institution $institution)
    {
        $this->institution = $institution;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\Person\FunctionType $functionType
     */
    public function setFunctionType(\Nordkirche\Ndk\Domain\Model\Person\FunctionType $functionType)
    {
        $this->functionType = $functionType;
    }

    /**
     * @param \Nordkirche\Ndk\Service\Result
     * @subtype \Nordkirche\Ndk\Domain\Model\Person\PersonFunction
     */
    public function setFunctions(\Nordkirche\Ndk\Service\Result $functions)
    {
        $this->functions = $functions;
    }

}