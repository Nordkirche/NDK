<?php

namespace Nordkirche\Ndk\Domain\Model;

use Nordkirche\Ndk\Domain\Interfaces\ModelInterface;
use Nordkirche\Ndk\Service\Interfaces\ResourceObjectInterface;
use Nordkirche\Ndk\Service\MissingResourceProxy;
use Nordkirche\Ndk\Service\NapiService;
use Nordkirche\Ndk\Service\ResolutionProxy;
use SplObjectStorage;

abstract class AbstractResourceObject extends AbstractModel implements ResourceObjectInterface
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * Additional data for a resource object
     * @var MetaData
     */
    private $metaData;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @return MetaData
     */
    public function getMetaData(): MetaData
    {
        return $this->metaData;
    }

    /**
     * @param MetaData $metaData
     */
    public function setMetaData(MetaData $metaData)
    {
        $this->metaData = $metaData;
    }

    /**
     * Returns a string which should help identify the resource with detailed information. Can be used in your backend
     * implementation to display more Information.
     *
     * This implementation only enriches getLabel with additional resource
     * information. Implement your own in each resource object to generate more useful labels like
     *
     * e.g. Event XY 2017-10-06 (ID: 293134)
     *
     * @return string
     */
    public function getDetailedLabel(): string
    {
        return sprintf('%s (%s:%s)', $this->getLabel(), $this->getType(), $this->getId());
    }

    /**
     * Returns a string which should be a simple readable representation for common users
     *
     * e.g. the title or name of a resource
     *
     * @return string
     */
    abstract public function getLabel(): string;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified(): \DateTime
    {
        return $this->lastModified;
    }

    /**
     * @param string $lastModified
     */
    public function setLastModified(string $lastModified)
    {
        $this->lastModified = new \DateTime($lastModified);
    }

    /**
     * Returns a URL to this object, resolvable by the NapiService
     * @return string
     */
    public function __toString()
    {
        return NapiService::returnNapiUrlFromObject($this);
    }

    /**
     * Automatically resolves a ResolutionProxy object.
     * You have to remove the getter methods which could return a resolution proxy.
     * Please define those magic getters via method annotation for each class.
     *
     * @param $method
     * @param $args
     *
     * @return mixed|ModelInterface|SplObjectStorage
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 3) === 'get') {
            $attribute = lcfirst(substr($method, 3));

            return $this->retrieveAttribute($attribute);
        }

        return null;
    }

    /**
     * @param string $attribute
     *
     * @return mixed|ModelInterface|SplObjectStorage
     */
    private function retrieveAttribute(string $attribute)
    {
        $value = $this->{$attribute};

        if ($value instanceof ResolutionProxy) {
            $this->{$attribute} = $value->resolve();
        } elseif ($value instanceof MissingResourceProxy) {
            $value->logAccess();
            $this->{$attribute} = null;
        }

        return $this->{$attribute};
    }

    /**
     * @param $attribute
     *
     * @return mixed|ModelInterface|SplObjectStorage
     */
    public function __get($attribute)
    {
        return $this->retrieveAttribute($attribute);
    }
}
