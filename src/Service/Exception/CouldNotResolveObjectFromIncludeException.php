<?php

namespace Nordkirche\Ndk\Service\Exception;

use Throwable;

class CouldNotResolveObjectFromIncludeException extends NdkException
{
    public function __construct(string $type, string $id, $code = 0, Throwable $previous = null)
    {
        $message = sprintf("Could not resolve id=$id type=$type via includes");
        parent::__construct($message, $code, $previous);
    }
}
