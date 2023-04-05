<?php

namespace Nordkirche\Ndk;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class Configuration
{
    const CONTEXT_PRODUCTION = 'Production';
    const CONTEXT_DEBUGGING = 'Debugging';
    const CONTEXT_TESTING = 'Testing';
    const PROTOCOL_HTTP = 'http';
    const PROTOCOL_HTTPS = 'https';

    /**
     * @var string Configuration::PROTOCOL_HTTP | Configuration::PROTOCOL_HTTPS
     */
    protected $napiProtocol = self::PROTOCOL_HTTPS;

    /**
     * @var string
     */
    protected $napiHost = 'localhost';

    /**
     * @var int
     */
    protected $napiPort = 443;

    /**
     * @var string
     */
    protected $napiPath = '';

    /**
     * @var integer
     */
    protected $napiVersion = 1;

    /**
     * @var integer
     */
    protected $napiUid;

    /**
     * @var string
     */
    protected $napiAccessToken;

    /**
     * @var array ['username','password']
     */
    protected $httpAuth = [];

    /**
     * @var float
     */
    protected $requestTimeout = 5.0;

    /**
     * @var \Closure
     */
    protected $placeholderLabelClosure;

    /**
     * @var CacheProvider
     */
    protected $reflectionCacheProvider;

    /**
     * @var CacheProvider
     */
    protected $dependencyInjectionCacheProvider;

    /**
     * @var CacheProvider
     */
    protected $httpCacheProvider;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \GuzzleHttp\MessageFormatter
     */
    protected $logMessageFormatter;

    /**
     * @var boolean
     */
    protected $resolutionProxyDisabled = false;

    /**
     * Maps a resource object type to a specific class
     * @var array
     */
    protected $typeClassMap = [
        'people' => Domain\Model\Person\Person::class,
        'teams' => Domain\Model\Institution\Team::class,
        'functions' => Domain\Model\Person\PersonFunction::class,
        'function_types' => \Nordkirche\Ndk\Domain\Model\Person\FunctionType::class,
        'events' => Domain\Model\Event\Event::class,
        'event_locations' => Domain\Model\Event\EventLocation::class,
        'addresses' => Domain\Model\Address::class,
        'categories' => Domain\Model\Category::class,
        'institutions' => Domain\Model\Institution\Institution::class,
        'institution_types' => Domain\Model\Institution\InstitutionType::class,
        'available_functions' => Domain\Model\Person\AvailableFunction::class,
        'offertories' => Domain\Model\Offertory\Offertory::class,
        'target_groups' => Domain\Model\Event\TargetGroup::class
    ];

    /**
     * The current appilication context. Uses self::CONTEXT_*.
     * @var string
     */
    protected $context;

    public function __construct(
        int $napiUid,
        string $napiAccessToken,
        string $napiHost = null,
        int $napiPort = null,
        string $napiPath = null,
        string $napiProtocol = null,
        int $napiVersion = null,
        array $httpAuth = []
    ) {
        $this->setNapiUid($napiUid);
        $this->setNapiAccessToken($napiAccessToken);
        $napiProtocol && $this->setNapiProtocol($napiProtocol);
        $napiHost && $this->setNapiHost($napiHost);
        $napiPath && $this->setNapiPath($napiPath);
        $napiPort && $this->setNapiPort($napiPort);
        $napiVersion && $this->setNapiVersion($napiVersion);
        $httpAuth && $this->setHttpAuth($httpAuth);

        $this->placeholderLabelClosure = function (Domain\Model\ResourcePlaceholder $placeholder) {
            return $placeholder->getType() . ':' . $placeholder->getId();
        };

        $cachePool = new ArrayAdapter();

        $defaultCacheProvider = DoctrineProvider::wrap($cachePool);
        $this->setReflectionCacheProvider(clone $defaultCacheProvider);
        $this->setDependencyInjectionCacheProvider(clone $defaultCacheProvider);
        $this->setHttpCacheProvider(clone $defaultCacheProvider);

        $this->setLogger((new \Monolog\Logger('Requests'))->pushHandler(new \Monolog\Handler\NullHandler()));
        $this->setLogMessageFormatter(new \GuzzleHttp\MessageFormatter('{uri} - {req_body}'));
    }

    /**
     * @return float
     */
    public function getRequestTimeout(): float
    {
        return $this->requestTimeout;
    }

    /**
     * Set the timeout for all requests in seconds
     *
     * @param float $requestTimeout
     */
    public function setRequestTimeout(float $requestTimeout)
    {
        $this->requestTimeout = $requestTimeout;
    }

    /**
     * @return int
     */
    public function getNapiUid(): int
    {
        return $this->napiUid;
    }

    /**
     * @param int $napiUid
     *
     * @return Configuration
     */
    public function setNapiUid(int $napiUid): Configuration
    {
        $this->napiUid = $napiUid;

        return $this;
    }

    /**
     * @return string
     */
    public function getNapiAccessToken(): string
    {
        return $this->napiAccessToken;
    }

    /**
     * @param string $napiAccessToken
     *
     * @return Configuration
     */
    public function setNapiAccessToken(string $napiAccessToken): Configuration
    {
        $this->napiAccessToken = $napiAccessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getNapiProtocol(): string
    {
        return $this->napiProtocol;
    }

    /**
     * @param string $napiProtocol
     *
     * @return Configuration
     */
    public function setNapiProtocol(string $napiProtocol): Configuration
    {
        $this->napiProtocol = $napiProtocol;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNapiHost()
    {
        return $this->napiHost;
    }

    /**
     * @param mixed $napiHost
     *
     * @return Configuration
     */
    public function setNapiHost($napiHost)
    {
        $this->napiHost = $napiHost;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNapiPath()
    {
        return $this->napiPath;
    }

    /**
     * @param mixed $napiPath
     *
     * @return Configuration
     */
    public function setNapiPath($napiPath)
    {
        $this->napiPath = $napiPath;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNapiVersion()
    {
        return $this->napiVersion;
    }

    /**
     * @param mixed $napiVersion
     *
     * @return Configuration
     */
    public function setNapiVersion($napiVersion)
    {
        $this->napiVersion = $napiVersion;

        return $this;
    }

    /**
     * @return array
     */
    public function getHttpAuth(): array
    {
        return $this->httpAuth;
    }

    /**
     * @param array $httpAuth
     *
     * @return Configuration
     */
    public function setHttpAuth(array $httpAuth): Configuration
    {
        $this->httpAuth = $httpAuth;

        return $this;
    }

    /**
     * @return array
     */
    public function getTypeClassMap(): array
    {
        return $this->typeClassMap;
    }

    /**
     * @param array $typeClassMap
     *
     * @return Configuration
     */
    public function setTypeClassMap(array $typeClassMap): Configuration
    {
        $this->typeClassMap = $typeClassMap;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNapiPort()
    {
        return $this->napiPort;
    }

    /**
     * @param mixed $napiPort
     *
     * @return Configuration
     */
    public function setNapiPort($napiPort)
    {
        $this->napiPort = $napiPort;

        return $this;
    }

    /**
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * @param string $context
     *
     * @return Configuration
     */
    public function setContext(string $context): Configuration
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return string
     * @throws \ErrorException
     */
    public function getClassnameForType(string $type): string
    {

        if ($this->hasClassnameForType($type)) {
            return $this->typeClassMap[$type];
        } else {
            throw new \ErrorException('There is no classname set for "' . $type . '"');
        }
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function hasClassnameForType(string $type): bool
    {
        return array_key_exists($type, $this->typeClassMap);
    }

    /**
     * @return \Closure
     */
    public function getPlaceholderLabelClosure(): \Closure
    {
        return $this->placeholderLabelClosure;
    }

    /**
     * @param \Closure $placeholderLabelClosure
     */
    public function setPlaceholderLabelClosure(\Closure $placeholderLabelClosure)
    {
        $this->placeholderLabelClosure = $placeholderLabelClosure;
    }

    /**
     * @return CacheProvider
     */
    public function getReflectionCacheProvider(): CacheProvider
    {
        return $this->reflectionCacheProvider;
    }

    /**
     * @param CacheProvider $reflectionCacheProvider
     *
     * @return Configuration
     */
    public function setReflectionCacheProvider(CacheProvider $reflectionCacheProvider): Configuration
    {
        $this->reflectionCacheProvider = $reflectionCacheProvider;
        $this->reflectionCacheProvider->setNamespace('ndk_reflection_cache');

        return $this;
    }

    /**
     * @return CacheProvider
     */
    public function getDependencyInjectionCacheProvider(): CacheProvider
    {
        return $this->dependencyInjectionCacheProvider;
    }

    /**
     * @param CacheProvider $dependencyInjectionCacheProvider
     *
     * @return Configuration
     */
    public function setDependencyInjectionCacheProvider(CacheProvider $dependencyInjectionCacheProvider): Configuration
    {
        $this->dependencyInjectionCacheProvider = $dependencyInjectionCacheProvider;
        $this->dependencyInjectionCacheProvider->setNamespace('ndk_di_cache');

        return $this;
    }

    /**
     * @return CacheProvider
     */
    public function getHttpCacheProvider(): CacheProvider
    {
        return $this->httpCacheProvider;
    }

    /**
     * @param CacheProvider $httpCacheProvider
     *
     * @return $this
     */
    public function setHttpCacheProvider(CacheProvider $httpCacheProvider)
    {
        $this->httpCacheProvider = $httpCacheProvider;
        $this->httpCacheProvider->setNamespace('ndk_http_cache');

        return $this;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger(): \Psr\Log\LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return \GuzzleHttp\MessageFormatter
     */
    public function getLogMessageFormatter(): \GuzzleHttp\MessageFormatter
    {
        return $this->logMessageFormatter;
    }

    /**
     * @param \GuzzleHttp\MessageFormatter $logMessageFormatter
     *
     * @return $this
     */
    public function setLogMessageFormatter(\GuzzleHttp\MessageFormatter $logMessageFormatter)
    {
        $this->logMessageFormatter = $logMessageFormatter;

        return $this;
    }

    /**
     * @return bool
     */
    public function isResolutionProxyDisabled(): bool
    {
        return $this->resolutionProxyDisabled;
    }

    /**
     * @param bool $resolutionProxyDisabled
     *
     * @return Configuration
     */
    public function setResolutionProxyDisabled(bool $resolutionProxyDisabled): Configuration
    {
        $this->resolutionProxyDisabled = $resolutionProxyDisabled;

        return $this;
    }
}
