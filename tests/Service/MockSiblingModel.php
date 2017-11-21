<?php

namespace Nordkirche\Ndk\Service;

class MockSiblingModel extends \Nordkirche\Ndk\Domain\Model\AbstractResourceObject
{

    public function getLabel(): string
    {
        // TODO: Implement getLabel() method.
    }

    /**
     * @var integer
     */
    protected $integer;

    /**
     * @var string
     */
    protected $string;

    /**
     * @var MockSiblingModel
     */
    protected $object;

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
     * @return MockSiblingModel
     */
    public function getObject(): MockSiblingModel
    {
        return $this->object;
    }

    /**
     * @param MockSiblingModel $object
     */
    public function setObject(MockSiblingModel $object)
    {
        $this->object = $object;
    }

}