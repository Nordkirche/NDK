<?php

namespace Nordkirche\Ndk\Service\Interfaces;

interface QueryInterface
{

    const OPERATOR_AND = 'AND';
    const OPERATOR_OR = 'OR';


    /**
     * Returns the filters parameters as an array
     *
     * @return array
     */
    public function returnUrlParameters(): array;

    /**
     * Returns the filters parameters to append to an url
     *
     * @return string
     */
    public function __toString(): string;
}
