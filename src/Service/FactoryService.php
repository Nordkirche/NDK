<?php

namespace Nordkirche\Ndk\Service;

use DI\Scope;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Nordkirche\Ndk\Configuration;
use phpDocumentor\Reflection\DocBlockFactory;

class FactoryService
{

    /**
     * Our DI container
     * @var \DI\Container
     */
    private $container;

    public function __construct(Configuration $configuration)
    {
        // For Development only
        $builder = new \DI\ContainerBuilder();
        $builder->setDefinitionCache($configuration->getDependencyInjectionCacheProvider());
        $builder->useAnnotations(false);

        $builder->addDefinitions(
            [
                // Configuration
                Configuration::class => function () use ($configuration) {
                    return $configuration;
                },

                // Services
                FactoryService::class => function () {
                    return $this;
                },

                NapiService::class => \DI\factory(function () use ($configuration) {

                    $clientConfiguration = [
                        'timeout' => $configuration->getRequestTimeout(),
                        'headers' => [
                            'Content-Type' => 'application/vnd.api+json',
                            'Accept' => 'application/vnd.api+json',
                            'uid' => $configuration->getNapiUid(),
                            'access-token' => $configuration->getNapiAccessToken()
                        ],
                        'base_uri' =>
                            $configuration->getNapiProtocol() . '://' .
                            $configuration->getNapiHost() . ':' .
                            $configuration->getNapiPort() . '/' .
                            $configuration->getNapiPath() .
                            'v' . $configuration->getNapiVersion() . '/'
                    ];

                    if ($configuration->getHttpAuth()) {
                        $clientConfiguration['auth'] = $configuration->getHttpAuth();
                    }

                    $stack = HandlerStack::create();
                    $stack->push(new CacheMiddleware(
                        new PrivateCacheStrategy(
                            new DoctrineCacheStorage(
                                $configuration->getHttpCacheProvider()
                            )
                        )
                    ), 'cache');

                    $stack->push(
                        \GuzzleHttp\Middleware::log(
                            $configuration->getLogger(),
                            $configuration->getLogMessageFormatter()
                        ), 'logger'
                    );

                    $clientConfiguration['handler'] = $stack;

                    $client = new Client($clientConfiguration);

                    return new NapiService($client, $this->container->get(ResolutionService::class), $configuration);
                })->scope(Scope::SINGLETON),

                // Decorator for Models
                ModelDecoratorService::class => \DI\object(ModelDecoratorService::class)->scope(Scope::SINGLETON),

                // Cache Service giving easy access to different caches
                CacheService::class => \DI\object(CacheService::class)->scope(Scope::SINGLETON),

                // 3rd-Party
                DocBlockFactory::class => function () {
                    return DocBlockFactory::createInstance();
                }
            ]
        );
        $this->container = $builder->build();
    }

    /**
     * Shortcut to containers get() method
     *
     * @param string $classname
     *
     * @return mixed
     */
    public function get(string $classname)
    {
        return $this->container->get($classname);
    }

    /**
     * Shortcut to containers make() method
     *
     * @param string $classname
     * @param array $parameters
     *
     * @return mixed
     */
    public function make(string $classname, array $parameters = [])
    {
        return $this->container->make($classname, $parameters);
    }
}
