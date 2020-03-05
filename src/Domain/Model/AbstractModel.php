<?php

namespace Nordkirche\Ndk\Domain\Model;

use Nordkirche\Ndk\Domain\Interfaces\ModelInterface;
use Nordkirche\Ndk\Service\Interfaces\ProxyInterface;

abstract class AbstractModel implements ModelInterface
{

    /**
     * Internal method to overwrite a value with a ResolutionProxy without using setters
     *
     * @param string $attribute
     * @param ProxyInterface $proxy
     *
     * @internal
     */
    public function __setProxyInstance(string $attribute, ProxyInterface $proxy)
    {
        $attribute = lcfirst(\Nordkirche\Ndk\Service\StringUtilites::camelize($attribute));
        $this->{$attribute} = $proxy;
    }
}
