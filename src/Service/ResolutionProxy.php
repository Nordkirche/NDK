<?php

namespace Nordkirche\Ndk\Service;

class ResolutionProxy
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * @var NapiService
     */
    protected $napiService;

    public function __construct(
        NapiService $napiService,
        string $uri
    ) {
        $this->napiService = $napiService;
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return \Nordkirche\Ndk\Domain\Interfaces\ModelInterface|Result|null
     */
    public function resolve()
    {
        return $this->napiService->get($this->uri);
    }
}
