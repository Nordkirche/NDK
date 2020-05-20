<?php

namespace Nordkirche\Ndk\Service;

use Psr\Http\Message\ResponseInterface;

class Response
{

    /**
     * The complete response object
     * @var ResponseInterface
     */
    private $rawReponse;

    /**
     * The actual data
     * @var array
     */
    private $rawData = [];

    /**
     * Meta data like page_count etc.
     * @var array
     */
    private $meta = [];

    /**
     * A list of links in relation to the request
     * @var array
     */
    private $links = [];

    /**
     * All included data, referenced in the data section
     * @var array
     */
    private $included = [];

    /**
     * @var \Nordkirche\Ndk\Domain\Model\AbstractModel|\SplObjectStorage|null
     */
    private $primaryData = null;

    public function __construct(ResponseInterface $rawResponse, array $parsedBody)
    {
        $this->rawReponse = $rawResponse;

        // populate internal properties
        foreach (['data' => 'rawData', 'meta', 'links', 'included'] as $sourceKey => $targetProperty) {
            if (is_numeric($sourceKey)) {
                $sourceKey = $targetProperty;
            }

            $this->$targetProperty = array_key_exists($sourceKey, $parsedBody) ? $parsedBody[$sourceKey] : [];
        }
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param array $links
     */
    public function setLinks(array $links)
    {
        $this->links = $links;
    }

    /**
     * @return ResponseInterface
     */
    public function getRawReponse(): ResponseInterface
    {
        return $this->rawReponse;
    }

    /**
     * @return array|null
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * @param array $rawData
     */
    public function setRawData(array $rawData)
    {
        $this->rawData = $rawData;
    }

    /**
     * @param string|null $key Get a specific key from meta data
     *
     * @return mixed
     */
    public function getMeta($key = null)
    {
        if ($key === null) {
            return $this->meta;
        } else {
            return isset($this->meta[$key]) ? $this->meta[$key] : [];
        }
    }

    /**
     * @param array $meta
     */
    public function setMeta(array $meta)
    {
        $this->meta = $meta;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasMeta($key = null): bool
    {
        if ($key === null) {
            return (bool)$this->meta;
        } else {
            return array_key_exists($key, $this->meta);
        }
    }

    /**
     * Return the whole include array or only one item
     *
     * @param string $type
     * @param string $id
     *
     * @return array
     */
    public function getIncluded(string $type = null, string $id = null): array
    {
        if ($type && $id) {
            $result = array_filter($this->included, function ($row) use ($type, $id) {
                return $row['type'] === $type && $row['id'] === $id;
            });

            if ((bool)$result) {
                return array_values($result)[0];
            } else {
                return [];
            }
        }

        return $this->included;
    }

    /**
     * @return \Nordkirche\Ndk\Domain\Model\AbstractModel|\SplObjectStorage|null
     */
    public function getPrimaryData()
    {
        return $this->primaryData;
    }

    /**
     * @param \Nordkirche\Ndk\Domain\Model\AbstractModel|\SplObjectStorage $primaryData
     */
    public function setPrimaryData($primaryData)
    {
        $this->primaryData = $primaryData;
    }
}
