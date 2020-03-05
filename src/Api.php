<?php

namespace Nordkirche\Ndk;

use Nordkirche\Ndk\Service\FactoryService;

class Api
{

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var FactoryService
     */
    private $factory;

    /**
     * @var Api
     */
    public static $api;

    public function __construct(Configuration $configuration)
    {
        self::$api = $this;
        $this->configuration = $configuration;
        $this->factory = new FactoryService($configuration);
    }

    /**
     * @param string $classname
     *
     * @return FactoryService|object Returns the FactoryService or an instance of the given $classname
     */
    public function factory($classname = null)
    {
        if ($classname) {
            $return = $this->factory->get($classname);
        } else {
            $return = $this->factory;
        }

        return $return;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }
}
