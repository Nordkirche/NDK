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
     * @throws \LogicException if the model does not declare the property (dynamic properties are deprecated since PHP 8.2)
     *
     * @internal
     */
    public function __setProxyInstance(string $attribute, ProxyInterface $proxy)
    {
        $attribute = lcfirst(\Nordkirche\Ndk\Service\StringUtilites::camelize($attribute));
        if (!property_exists($this, $attribute)) {
            throw new \LogicException(
                sprintf('Property %s::$%s must be declared to hold a relation proxy', static::class, $attribute),
                1758710400
            );
        }
        $this->{$attribute} = $proxy;
    }
}
