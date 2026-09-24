<?php

namespace Nordkirche\Ndk\Service;

class CacheService
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    protected $reflectionCache;

    public function __construct(\Nordkirche\Ndk\Configuration $configuration)
    {
        $this->reflectionCache = $configuration->getReflectionCacheProvider();
    }

    /**
     * @return \Psr\Cache\CacheItemPoolInterface
     */
    public function getReflectionCache(): \Psr\Cache\CacheItemPoolInterface
    {
        return $this->reflectionCache;
    }
}
