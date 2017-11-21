<?php

namespace Nordkirche\Ndk\Service;

use Nordkirche\Ndk\Domain\Interfaces\ModelInterface;
use Nordkirche\Ndk\Domain\Model\AbstractModel;
use phpDocumentor\Reflection\DocBlockFactory;

class ModelDecoratorService
{

    /**
     * @var DocBlockFactory
     */
    protected $docBlockParser;

    /**
     * @var FactoryService
     */
    protected $factoryService;

    /**
     * @var ReflectionService
     */
    protected $reflectionService;

    public function __construct(
        DocBlockFactory $docBlockFactory,
        FactoryService $factoryService,
        ReflectionService $reflectionService
    ) {
        $this->docBlockParser = $docBlockFactory;
        $this->factoryService = $factoryService;
        $this->reflectionService = $reflectionService;
    }

    /**
     * @param ModelInterface $model
     * @param array $attributes
     *
     * @return ModelInterface
     */
    public function decorateObject(ModelInterface $model, array $attributes): ModelInterface
    {
        foreach ($attributes as $property => $value) {
            $this->setValueOnModel($model, $property, $value);
        }

        return $model;
    }

    /**
     * @param ModelInterface $model
     * @param string $property
     * @param mixed $value
     */
    protected function setValueOnModel(ModelInterface $model, string $property, $value)
    {
        $setterMethodName = 'set' . StringUtilites::camelize($property);
        if (method_exists($model, $setterMethodName)) {
            if ($model instanceof AbstractModel && $value instanceof ResolutionProxy) {
                $model->__setProxyInstance($property, $value);
            } else {
                list($expectedType, $isBuiltIn, $subType) =
                    $this->reflectionService->returnExpectedType($model, $setterMethodName);

                $value = $this->transform($value, $expectedType, $isBuiltIn, $subType);
                if ($value !== null) {
                    call_user_func([$model, $setterMethodName], $value);
                }
            }
        }
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function underscoreToCamelCase(string $string): string
    {
        return str_replace('_', '', ucwords($string, '_'));
    }

    /**
     * @param mixed $value
     * @param string $expectedType
     * @param bool $isBuiltIn
     * @param string $subType
     *
     * @return mixed
     */
    protected function transform($value, string $expectedType, bool $isBuiltIn, $subType = null)
    {
        if ($expectedType === null) {
            return $value;
        }

        if ($value instanceof $expectedType || $isBuiltIn) {
            return $value;
        }

        if ($expectedType === Result::class && is_array($value)) {
            $childObject = new Result(new \SplObjectStorage(), 1, sizeof($value));
            return $this->buildObjectStorage($childObject, $value, $subType);
        } else {
            $childObject = $this->factoryService->make($expectedType);
        }

        if (is_array($value)) {
            /** @var AbstractModel $childObject */
            return $this->decorateObject($childObject, $value);
        } else {
            return null;
        }
    }

    /**
     * @param Result $storage
     * @param array $entries
     * @param string $subType
     *
     * @return Result
     */
    protected function buildObjectStorage(Result $storage, array $entries, string $subType): Result
    {

        foreach ($entries as $entry) {
            if ($entry instanceof $subType) {
                $subModel = $entry;
            } else {
                $subModel = $this->factoryService->make($subType);
                $subModel = $this->decorateObject($subModel, $entry);
            }
            $storage->getObjects()->attach($subModel);
        }
        $storage->rewind();

        return $storage;
    }
}
