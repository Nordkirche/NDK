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
        $client = $this->napiService->getClient();

        $response = $client->get($this->resource.(string)$query, [
            'allow_redirects' => false
        ]);

        if ($response->getStatusCode() === 302) {
            return $response->getHeader('Location')[0];
        }

        return null;
    }
}
