<?php

namespace Nordkirche\Ndk\Domain\Endpoint;

class SuggestEndpoint extends AbstractEndpoint
{
    protected $resource = 'suggest';

    /**
     * Returns an array with suggested words as an array
     *
     * @param $query \Nordkirche\Ndk\Service\Interfaces\QueryInterface
     *
     * @return array
     */
    public function query($query = null)
    {
        $client = $this->napiService->getClient();

        $response = $client->get($this->resource.(string)$query);

        if ($rawContent = $response->getBody()->getContents()) {
            $content = json_decode($rawContent);
            return $content->data;
        } else {
            return [];
        }
    }
}
