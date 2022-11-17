<?php

namespace Nordkirche\Ndk\Domain\Endpoint;

class ImageEndpoint extends AbstractEndpoint
{
    protected $resource = 'images';

    /**
     * We need to handle a special case, where we get a redirect as a result
     *
     * @param $query \Nordkirche\Ndk\Service\Interfaces\QueryInterface
     *
     * @return string
     */
    public function query($query = null)
    {
        $uri = $this->napiService->getClient()->getConfig('base_uri');

        $baseUri = $uri->getScheme() === '' && $uri->getHost() !== '' ? $uri->withScheme('http') : $uri;

        return (string) $baseUri . $this->resource. (string) $query;
    }
}
