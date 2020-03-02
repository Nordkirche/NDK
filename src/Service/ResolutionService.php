<?php

namespace Nordkirche\Ndk\Service;

use Nordkirche\Ndk\Configuration;
use Nordkirche\Ndk\Domain\Model\AbstractModel;
use Nordkirche\Ndk\Service\Exception\CouldNotResolveObjectFromIncludeException;

class ResolutionService
{

    /**
     * A map for objects
     * @var array
     */
    protected $objectMap = [];

    /**
     * @var FactoryService
     */
    protected $factoryService;

    /**
     * @var ModelDecoratorService
     */
    protected $modelDecoratorService;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var Response
     */
    protected $currentResponse;

    /**
     * ResolutionService constructor.
     *
     * @param FactoryService $factoryService
     * @param Configuration $configuration
     * @param ModelDecoratorService $modelDecoratorService
     */
    public function __construct(
        FactoryService $factoryService,
        Configuration $configuration,
        ModelDecoratorService $modelDecoratorService
    ) {
        $this->factoryService = $factoryService;
        $this->configuration = $configuration;
        $this->modelDecoratorService = $modelDecoratorService;
    }

    /**
     * Decorates a response from NapiService with real objects and holds an index of all included objects
     * to resolve them correctly in primary data
     *
     * @param Response $response
     */
    public function resolve(Response $response)
    {
        $this->currentResponse = $response;
        $this->resolveIncluded();
        $this->resolvePrimaryData();
    }

    protected function resolveIncluded()
    {
        // Resolve included objects and create object map
        $objects = array_map(
            function ($data) {
                return $this->resolveObject($data);
            },
            $this->currentResponse->getIncluded()
        );
        $this->objectMap += $this->returnObjectTypeIdMap($objects);
    }

    /**
     * @param array $data
     *
     * @return AbstractModel|null
     */
    protected function resolveObject(array $data)
    {
        if ($this->has($data['type'], $data['id'])) {
            return $this->get($data['type'], $data['id']);
        }

        if ($this->configuration->hasClassnameForType($data['type'])) {
            $classname = $this->configuration->getClassnameForType($data['type']);

            /** @var AbstractModel $object */
            $object = $this->factoryService->make($classname);
            $this->modelDecoratorService->decorateObject($object, $this->returnModelPropertiesFromData($data));
            $this->add($object, $data['type'], $data['id']);

            return $object;
        }

        return null;
    }

    /**
     * @param string $type
     * @param int $id
     *
     * @return bool
     */
    public function has(string $type, int $id)
    {
        return isset($this->objectMap[$type][$id]);
    }

    /**
     * Very lowlevel method to resolve a relationship
     *
     * @param string $type
     * @param string $id
     *
     * @return AbstractModel|null
     */
    public function get(string $type, string $id)
    {
        if (isset($this->objectMap[$type])) {
            $result = array_filter($this->objectMap[$type], function (AbstractModel $object) use ($id) {
                return $object->getId() == $id;
            });

            if (!empty($result) && is_array($result)) {
                return array_pop($result);
            }
        }

        try {
            return $this->resolveObjectFromIncludes($type, $id)
                ?? $this->factoryService->make(ResolutionProxy::class, ['uri' => $type . '/' . $id]);
        } catch (CouldNotResolveObjectFromIncludeException $e) {
            $logger = $this->factoryService->get(Configuration::class)->getLogger();
            $logger->info('Skipped relationship because it was not found in includes', [
                'type' => $type,
                'id' => $id
            ]);
            return null;
        }
    }

    /**
     * Resolves a specific object found in included
     *
     * @param string $type
     * @param string $id
     *
     * @return AbstractModel
     * @throws CouldNotResolveObjectFromIncludeException
     */
    protected function resolveObjectFromIncludes(string $type, string $id)
    {
        $result = $this->currentResponse->getIncluded($type, $id);
        if ($result) {
            return $this->resolveObject($result);
        }

        throw new CouldNotResolveObjectFromIncludeException($type, $id, 1583145366);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function returnModelPropertiesFromData($data)
    {
        // merge attributes with id and type to populate basic values
        if (isset($data['attributes'])) {
            $attributes = $data['attributes'];
        } else {
            $attributes = $data;
        }

        if ($data['id']) {
            $attributes['id'] = $data['id'];
        }

        if ($data['type']) {
            $attributes['type'] = $data['type'];
        }

        if (isset($data['meta'])) {
            $metaDataObject = new \Nordkirche\Ndk\Domain\Model\MetaData();
            $metaDataObject->setMetaData($data['meta']);
            $attributes['meta_data'] = $metaDataObject;
        }

        // resolve objects in relationships from include and populate attributes with them
        if (isset($data['relationships'])) {
            $relations = $this->resolveRelationships($data['relationships']);
            $attributes = array_merge($attributes, $relations);
        }

        return $attributes;
    }

    /**
     * Takes the raw relationships section from the response body and maps them with the
     * apropiate objects
     *
     * @param array $relationships can be a single raw relation with [data][id] and [data][type] or a set of those
     *
     * @return AbstractModel|AbstractModel[]|null
     */
    protected function resolveRelationships(array $relationships)
    {
        if (is_array($relationships)) {
            $map = array_map([$this, 'resolveSingleRelationship'], $relationships);

            // filter not resolved objects
            return array_filter($map, function ($value) {
                return (bool)$value;
            });
        }
    }

    /**
     * @param mixed $object
     * @param string $type
     * @param int $id
     *
     * @throws \ErrorException
     */
    protected function add($object, string $type, int $id)
    {
        if (!isset($this->objectMap[$type][$id])) {
            $this->objectMap[$type][$id] = $object;
        } else {
            throw new \ErrorException(
                'You cannot overwrite objects on the object map. Type/ID: ' . $type . '/' . $id,
                1494241664
            );
        }
    }

    /**
     * Creates a type-id based map for a set of AbstractModels
     *
     * @param array $objects
     *
     * @return array
     */
    protected function returnObjectTypeIdMap(array $objects): array
    {
        $keyMap = array_map(
            function ($objectData) {
                if ($objectData instanceof \Nordkirche\Ndk\Domain\Model\AbstractResourceObject) {
                    return $objectData->getType();
                }
            },
            $objects
        );

        $objectMap = [];

        foreach ($keyMap as $key) {
            $objectMap[$key] = array_filter(
                $objects,
                function ($objectData) use ($key) {
                    return
                        $objectData instanceof \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
                        && $objectData->getType() === $key;
                }
            );
        }

        return $objectMap;
    }

    /**
     * Resolves the primary data of the current response object
     */
    protected function resolvePrimaryData()
    {
        if (is_array($this->currentResponse->getRawData())) {
            if ($this->isCollection($this->currentResponse->getRawData())) {
                $primaryData = new Result(
                    new \SplObjectStorage(),
                    $this->currentResponse->getMeta('page_count'),
                    $this->currentResponse->getMeta('record_count'),
                    $this->currentResponse->getMeta('facets')
                );
                foreach ($this->currentResponse->getRawData() as $data) {
                    if ($object = $this->resolveObject($data)) {
                        $primaryData->getObjects()->attach($object);
                    }
                }
                $primaryData->rewind();
            } else {
                $primaryData = $this->resolveObject($this->currentResponse->getRawData());
            }

            $this->currentResponse->setPrimaryData($primaryData);
        }
    }

    /**
     * @param array $rawData
     *
     * @return bool
     */
    private function isCollection(array $rawData): bool
    {
        return array_key_exists('type', $rawData) ? false : true;
    }

    /**
     * @param array $relation
     *
     * @return AbstractModel|Result
     */
    protected function resolveSingleRelationship(array $relation)
    {
        if ($this->isSingleRelationship($relation)) {
            return $this->resolveRelation($relation['data']);
        } elseif (isset($relation['data']) && is_array($relation['data'])) {
            return $this->resolveRelations($relation['data']);
        } elseif (isset($relation['links']) && isset($relation['links']['related'])) {
            return $this->factoryService->make(
                ResolutionProxy::class,
                ['uri' => $relation['links']['related']]
            );
        }
    }

    /**
     * Check if the relationship data represent a single or multiple resources
     *
     * @param array $relation
     *
     * @return bool
     */
    private function isSingleRelationship(array $relation)
    {
        return isset($relation['data']['type']) && isset($relation['data']['id']);
    }

    /**
     * @param array $relationData
     *
     * @return AbstractModel|null
     */
    protected function resolveRelation(array $relationData)
    {
        if (isset($relationData['type']) && isset($relationData['id'])) {
            return $this->get($relationData['type'], $relationData['id']);
        }

        return null;
    }

    /**
     * @param array $relationData
     *
     * @return Result
     */
    protected function resolveRelations(array $relationData)
    {
        $resultObject = new Result(new \SplObjectStorage(), 1, sizeof($relationData));
        foreach ($relationData as $data) {
            $object = $this->resolveRelation($data);
            if ($object !== null) {
                $resultObject->getObjects()->attach($object);
            }
        }
        $resultObject->rewind();

        return $resultObject;
    }
}
