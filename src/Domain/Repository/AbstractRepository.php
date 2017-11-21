<?php

namespace Nordkirche\Ndk\Domain\Repository;

use Nordkirche\Ndk\Domain\Interfaces\RepositoryInterface;
use Nordkirche\Ndk\Service\FactoryService;
use Nordkirche\Ndk\Service\NapiService;
use Nordkirche\Ndk\Service\ResolutionService;

abstract class AbstractRepository implements RepositoryInterface
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
    public function get($query = null)
    {
        $result = $this->napiService->get($this->resource, $query);

        return $result;
    }

    /**
     * @param int $id
     * @param string[] $include Array with fields to include
     *
     * @return \Nordkirche\Ndk\Domain\Interfaces\ModelInterface
     */
    public function getById(int $id, array $include = [])
    {
        $query = null;
        if ((bool)$include) {
            $query = (new \Nordkirche\Ndk\Domain\Query\SimpleQuery())->setInclude($include);
        }
        $result = $this->napiService->get($this->resource . '/' . $id, $query);

        return $result;
    }
}
