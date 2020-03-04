<?php

namespace Nordkirche\Ndk\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Nordkirche\Ndk\Configuration;
use Nordkirche\Ndk\Domain\Interfaces\ModelInterface;
use Nordkirche\Ndk\Domain\Model\ResourcePlaceholder;
use Nordkirche\Ndk\Service\Interfaces\QueryInterface;
use Nordkirche\Ndk\Service\Interfaces\ResourceObjectInterface;
use Psr\Http\Message\ResponseInterface;

class NapiService
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var ResolutionService
     */
    private $resolutionService;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Client $client, ResolutionService $resolutionService, Configuration $configuration)
    {
        $this->client = $client;
        $this->resolutionService = $resolutionService;
        $this->configuration = $configuration;
    }

    /**
     * Can return a NAPI Url to save in your own database to define relations
     *
     * @param ResourceObjectInterface $object
     *
     * @interal
     * @return string
     */
    public static function returnNapiUrlFromObject(ResourceObjectInterface $object)
    {
        return sprintf('napi://resource/%s/%u', $object->getType(), $object->getId());
    }

    /**
     * Can check if a url is a valid NAPI resource URL
     *
     * @param $url
     *
     * @internal
     * @return bool
     */
    public static function isUrl($url)
    {
        if (is_string($url)) {
            $urlParts = parse_url($url);
        } else {
            if (is_array($url) && isset($url['scheme'])) {
                $urlParts = $url;
            } else {
                return false;
            }
        }

        return isset($urlParts['scheme']) && $urlParts['scheme'] === 'napi';
    }

    /**
     * Resolve a URLs created by casting a object implementing ResourceObjectInterace to string
     *
     * @param $urls string[] An array of URLs like "[napi://resource/institutions/1, napi://resource/institutions/2]"
     * @param string[] $include Array with fields to include
     *
     * @return array|ResourceObjectInterface[]
     */
    public function resolveUrls(array $urls, array $include = []): array
    {
        return array_map(function ($url) use ($include) {
            return $this->resolveUrl($url, $include);
        }, $urls);
    }

    /**
     * Resolve a Url created by casting a object implementing ResourceObjectInterace to string
     *
     * @param $url string A single URL like "napi://resource/institutions/1"
     * @param string[] $include Array with fields to include
     * @param string[] $facets Array with facets
     *
     * @return ResourceObjectInterface
     */
    public function resolveUrl(string $url, array $include = [], array $facets = []): ResourceObjectInterface
    {
        $urlParts = parse_url($url);

        if ($urlParts['scheme'] !== 'napi' || $urlParts['host'] !== 'resource') {
            throw new \InvalidArgumentException('The URL provided does not begin with napi://resource', 1495185925);
        }

        list($type, $id) = self::parseResourceUrl($urlParts);

        if ($this->configuration->hasClassnameForType($type)) {
            try {
                $query = $this->createSimpleQuery($include, $facets);

                return $this->get($type . '/' . $id, $query);
            } catch (Exception\ResourceObjectNotFoundException $e) {
                $placeholder = new ResourcePlaceholder;
                $placeholder->setId($id);
                $placeholder->setType($type);

                return $placeholder;
            }
        } else {
            throw new \InvalidArgumentException(
                'The URL provided tries to access a resource the NDK does not know: ' . $type, 1495196889
            );
        }
    }

    /**
     * Returns resourcetype and id for a NAPI resource URL
     *
     * @param string|array $url
     *
     * @internal
     * @return string[] [resourceType,Id]
     */
    public static function parseResourceUrl($url)
    {
        if (is_string($url)) {
            $urlParts = parse_url($url);
        } else {
            if (is_array($url) && isset($url['path'])) {
                $urlParts = $url;
            } else {
                return [];
            }
        }

        return array_slice(explode('/', $urlParts['path']), 1);
    }

    /**
     * Returns a SimpleQuery object with setted includes if available
     *
     * @param array $include
     * @param array $facets
     *
     * @return \Nordkirche\Ndk\Domain\Query\SimpleQuery
     */
    protected function createSimpleQuery(
        array $include = [],
        array $facets = []
    ): \Nordkirche\Ndk\Domain\Query\SimpleQuery {
        $query = new \Nordkirche\Ndk\Domain\Query\SimpleQuery();
        if ((bool)$include) {
            $query->setInclude($include);
        }
        if ((bool)$facets) {
            $query->setFacets($facets);
        }

        return $query;
    }

    /**
     * @param string $path
     * @param QueryInterface $query
     *
     * @return ModelInterface|Result|null
     * @throws Exception\ServerException
     * @throws Exception\ClientException
     * @throws Exception\AccessDeniedException
     * @throws Exception\ResourceObjectNotFoundException
     * @throws Exception\TimeoutException
     */
    public function get(string $path, QueryInterface $query = null)
    {
        if ($query instanceof QueryInterface) {
            $path .= $query;
        }

        // Check if we already fetched the resource object and return it
        if ($this->isPathForResourceObject($path)) {
            list($type, $id) = $this->returnTypeAndIdFromPath($path);
            if ($this->resolutionService->has($type, $id)) {
                return $this->resolutionService->get($type, $id);
            }
        }

        try {
            $response = $this->buildResponseObject(
                $this->client->request('GET', $path)
            );
        } catch (ConnectException $e) {
            if (strpos($e->getMessage(), 'timed out')) {
                throw new Exception\TimeoutException(
                    'The request for ' . $path . ' timed out.',
                    1504025305,
                    $e->getRequest()->getUri(),
                    $e
                );
            }

            throw $e;
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response == null) {
                throw $e;
            } else {

                if ($response->getStatusCode() === 404 && $this->isPathForResourceObject($path)) {
                    throw new Exception\ResourceObjectNotFoundException(
                        'The reqeusted resource object ' . $path . ' is not available. ' .
                        'Status Code: ' . $response->getStatusCode() . "\n" . print_r($e->getMessage(),
                            true),
                        1496261856,
                        $e->getRequest()->getUri(),
                        $e
                    );
                }

                if ($response->getStatusCode() == 401 || $response->getStatusCode() == 403) {
                    throw new Exception\AccessDeniedException(
                        'Access to the reqeusted resource ' . $path . ' was denied. ' .
                        'Status Code: ' . $response->getStatusCode() . "\n" . print_r($e->getMessage(),
                            true),
                        1494246071,
                        $e->getRequest()->getUri(),
                        $e
                    );
                }

                if ($response->getStatusCode() > 400 && $response->getStatusCode() < 500) {
                    throw new Exception\ClientException(
                        'Requesting the resource ' . $path . ' ended in an client side error. ' .
                        'Status Code: ' . $response->getStatusCode() . "\n" . print_r($e->getMessage(),
                            true),
                        1494246071,
                        $e->getRequest()->getUri(),
                        $e
                    );
                }

                if ($response->getStatusCode() >= 500 && $response->getStatusCode()) {
                    throw new Exception\ServerException(
                        'Requesting the resource ' . $path . ' ended in an server side error. ' .
                        'Status Code: ' . $response->getStatusCode() . "\n" . print_r($e->getMessage(),
                            true),
                        1494246071,
                        $e->getRequest()->getUri(),
                        $e
                    );
                }

                $response = $this->buildResponseObject($response);
            }
        }

        $this->resolutionService->resolve($response);

        return $response->getPrimaryData();
    }

    /**
     * Can tell if a path is a NDK supported path to fetch a source object
     *
     * @param $path
     *
     * @return bool
     */
    protected function isPathForResourceObject($path)
    {
        $parts = $this->returnTypeAndIdFromPath($path);
        if (empty($parts)) {
            return false;
        }
        list($type, $id) = $parts;

        return is_numeric($id) && $this->configuration->hasClassnameForType($type);
    }

    /**
     * @param $path
     *
     * @return array [type, id]
     */
    public function returnTypeAndIdFromPath($path)
    {
        $parts = explode('/', $path);

        return sizeof($parts) === 2 ? $parts : [];
    }

    /**
     * @param ResponseInterface $response
     *
     * @return Response
     */
    protected function buildResponseObject(ResponseInterface $response): Response
    {
        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if ($data === null) {
            $data = [$body];
        }

        return new Response($response, $data);
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}
