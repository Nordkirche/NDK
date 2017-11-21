<?php

namespace Nordkirche\Ndk\Domain\Endpoint;

use Nordkirche\Ndk\Service\FactoryService;
use Nordkirche\Ndk\Service\NapiService;
use Nordkirche\Ndk\Service\ResolutionService;

abstract class AbstractEndpoint implements \Nordkirche\Ndk\Domain\Interfaces\EndpointInterface
{

    /**
     * @var string
     */
    protected $resource = '';

    /**
     * @var NapiService
     */
    protected $napiService;

    /**
     * @var FactoryService
     */
    protected $factoryService;

    /**
     * @var ResolutionService
     */
    protected $resolutionService;

    public function __construct(
        NapiService $napiService,
        FactoryService $factoryService,
        ResolutionService $resolutionService
    ) {
        $this->napiService = $napiService;
        $this->factoryService = $factoryService;
        $this->resolutionService = $resolutionService;
    }

    /**
     * @param $query \Nordkirche\Ndk\Service\Interfaces\QueryInterface
     *
     * @return \Nordkirche\Ndk\Service\Result
     */
    public function query($query = null)
    {
        $result = $this->napiService->get($this->resource, $query);

        return $result;
    }
}
