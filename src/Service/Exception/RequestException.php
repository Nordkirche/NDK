<?php

namespace Nordkirche\Ndk\Service\Exception;

class RequestException extends NdkException
{
    /**
     * @var
     */
    protected $uri;

    /**
     * RequestException constructor.
     *
     * @param string $message
     * @param int $code
     * @param string $uri - The URI the request was sent to
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, $uri = '', \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }
}
