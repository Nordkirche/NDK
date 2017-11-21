<?php

namespace Nordkirche\Ndk\Domain\Interfaces;

interface QueryParameterValue
{

    /**
     * Return a string which can be used a query parameter value
     * @return string
     */
    public function returnParameterValue(): string;
}
