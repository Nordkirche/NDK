<?php

namespace Nordkirche\Ndk\Service;

use Doctrine\Common\Cache\CacheProvider;
use Nordkirche\Ndk\Domain\Interfaces\ModelInterface;
use Nordkirche\Ndk\Domain\Model\AbstractModel;
use phpDocumentor\Reflection\DocBlockFactory;

class ReflectionService
{

    /**
     * @var DocBlockFactory
     */
    protected $docBlockParser;

    /**
     * @var CacheProvider
     */
    protected $cache;

    public function __construct(
        DocBlockFactory $docBlockFactory,
        CacheService $cacheService
    ) {
        $this->docBlockParser = $docBlockFactory;
        $this->cache = $cacheService->getReflectionCache();
    }

    /**
     * @param ModelInterface $model
     * @param string $method
     *
     * @return array
     * @throws \ErrorException
     */
    public function returnExpectedType(ModelInterface $model, string $method): array
    {
        $classname = get_class($model);
        $cacheId = $classname . '_' . $method;

        if ($this->cache->contains($cacheId)) {
            return $this->cache->fetch($cacheId);
        }

        $methodReflector = new \ReflectionMethod($classname, $method);
        $parameters = $methodReflector->getParameters();

        $type = $parameters[0]->getType();
        $subType = null;
        $typeString = null;

        if ($type !== null) {
            $typeString = $type->getName() ;
        }

        // We have to get the classname of the objects the object storage stores
        if ($typeString == Result::class) {
            if ($docComment = $methodReflector->getDocComment()) {
                $docBlock = $this->docBlockParser->create($docComment);
                list(, $subType) = explode(' ', $docBlock->getTagsByName('subtype')[0]->render());
            } else {
                throw new \ErrorException(
                    'Need php doc comment to do stuff on ' . $classname . '->' . $method,
                    1488223845
                );
            }
        }

        $result = [$typeString, $type->isBuiltin(), $subType];

        $this->cache->save($cacheId, $result);

        return $result;
    }
}
