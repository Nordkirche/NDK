<?php

namespace Nordkirche\Ndk\Service;

class CacheService
{
    /**
     * @var \Doctrine\Common\Cache\CacheProvider
     */
    protected $reflectionCache;

    public function __construct(\Nordkirche\Ndk\Configuration $configuration)
    {
        $this->reflectionCache = $configuration->getReflectionCacheProvider();
    }

    /**
     * @return \Doctrine\Common\Cache\CacheProvider
     */
    public function getReflectionCache(): \Doctrine\Common\Cache\CacheProvider
    {
        return $this->reflectionCache;
    }
}
