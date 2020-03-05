<?php

namespace Nordkirche\Ndk\Service;

use Nordkirche\Ndk\Configuration;
use Nordkirche\Ndk\Service\Interfaces\ProxyInterface;
use Nordkirche\Ndk\Service\Interfaces\ResourceObjectInterface;

/**
 * This object is used, when the ResolutionProxy-Feature is disabled. In this case we create this standin-object and use
 * it to log access to a missing relationship, which were not included but accessed.
 */
class MissingResourceProxy implements ResourceObjectInterface, ProxyInterface
{
    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $type = '';

    /**
     * @var FactoryService
     */
    private $factoryService = null;

    public function __construct(FactoryService $factoryService, string $id, string $type)
    {
        $this->factoryService = $factoryService;
        $this->id = $id;
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function logAccess(): void
    {
        $logger = $this->factoryService->get(Configuration::class)->getLogger();
        $logger->info('Skipped relationship because it was not found in includes', [
            'type' => $this->type,
            'id' => $this->id
        ]);
    }

    public function __toString(): string
    {
        return \Nordkirche\Ndk\Service\NapiService::returnNapiUrlFromObject($this);
    }
}
