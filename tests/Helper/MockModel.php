<?php

namespace Nordkirche\Ndk\Helper;

use Nordkirche\Ndk\Domain\Model\AbstractResourceObject;
use Nordkirche\Ndk\Service\MissingResourceProxy;
use Nordkirche\Ndk\Service\ResolutionProxy;
use Nordkirche\Ndk\Service\Result;

/**
 * @method MockSiblingModel getObject()
 * @property MockSiblingModel object
 */
class MockModel extends AbstractResourceObject
{

    /**
     * @var integer
     */
    protected $integer;

    /**
     * @var string
     */
    protected $string;

    /**
     * @var array
     */
    protected $array;

    /**
     * @var MockSiblingModel
     */
    protected $object;

    /**
     * @var Result
     */
    protected $resultObject;

    public function getLabel(): string
    {
        return 'Label';
    }

    /**
     * @return int
     */
    public function getInteger(): int
    {
        return $this->integer;
    }

    /**
     * @param int $integer
     */
    public function setInteger(int $integer)
    {
        $this->integer = $integer;
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
    }

    /**
     * @param string $string
     */
    public function setString(string $string)
    {
        $this->string = $string;
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return $this->array;
    }

    /**
     * @param array $array
     */
    public function setArray(array $array)
    {
        $this->array = $array;
    }

    /**
     * @param MockSiblingModel $object
     */
    public function setObject(MockSiblingModel $object)
    {
        $this->object = $object;
    }

    /**
     * @return MockSiblingModel|ResolutionProxy|MissingResourceProxy
     */
    public function getObjectRaw()
    {
        return $this->object;
    }

    /**
     * @return Result
     */
    public function getResultObject(): Result
    {
        return $this->resultObject;
    }

    /**
     * @param Result $resultObject
     * @subtype \Nordkirche\Ndk\Helper\MockSiblingModel
     */
    public function setResultObject(Result $resultObject)
    {
        $this->resultObject = $resultObject;
    }
}