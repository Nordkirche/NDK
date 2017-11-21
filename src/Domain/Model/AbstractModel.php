<?php

namespace Nordkirche\Ndk\Domain\Model;

use Nordkirche\Ndk\Domain\Interfaces\ModelInterface;

abstract class AbstractModel implements ModelInterface
{
    /**
     * Internal method to overwrite a value with a ResolutionProxy without using setters
     *
     * @param string $attribute
     * @param \Nordkirche\Ndk\Service\ResolutionProxy $proxy
     * @internal
     */
    public function __setProxyInstance(string $attribute, \Nordkirche\Ndk\Service\ResolutionProxy $proxy)
    {
        $attribute = lcfirst(\Nordkirche\Ndk\Service\StringUtilites::camelize($attribute));
        $this->{$attribute} = $proxy;
    }
}
