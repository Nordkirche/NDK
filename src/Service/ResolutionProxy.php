<?php

namespace Nordkirche\Ndk\Service;

use Nordkirche\Ndk\Domain\Interfaces\ModelInterface;
use Nordkirche\Ndk\Domain\Model\ResourcePlaceholder;
use Nordkirche\Ndk\Service\Exception\NdkException;
use Nordkirche\Ndk\Service\Interfaces\ProxyInterface;

class ResolutionProxy implements ProxyInterface
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
     * @return ModelInterface|Result|null
     */
    public function resolve()
    {
        try {
            return $this->napiService->get($this->uri);
        } catch (Exception\ResourceObjectNotFoundException $e) {
            return $this->buildResourcePlaceholder($e);
        } catch (Exception\TimeoutException $e) {
            return $this->buildResourcePlaceholder($e);
        } catch (Exception\ServerException $e) {
            return $this->buildResourcePlaceholder($e);
        }
    }

    private function buildResourcePlaceholder(NdkException $exception): ResourcePlaceholder
    {
        [$type, $id] = $this->napiService->returnTypeAndIdFromPath($this->uri);

        $placeholder = new ResourcePlaceholder();
        $placeholder->setLinkedException($exception);
        $placeholder->setId($id);
        $placeholder->setType($type);

        return $placeholder;
    }
}
