<?php

namespace Nordkirche\Ndk\Helper;

use Nordkirche\Ndk\Api;
use Nordkirche\Ndk\Configuration;

trait SetupApiTrait
{
    public function createApiInstance(Configuration $configuration = NULL)
    {
        if($configuration === NULL) {
            $configuration = new Configuration(
                (int) getenv('NDK_NAPI_UID'),
                getenv('NDK_NAPI_ACCESSTOKEN'),
                getenv('NDK_NAPI_HOST'),
                (int) getenv('NDK_NAPI_PORT'),
                getenv('NDK_NAPI_PATH'),
                getenv('NDK_NAPI_PROTOCOL'),
                (int) getenv('NDK_NAPI_VERSION'),
                [getenv('NDK_HTTP_AUTH_USERNAME'), getenv('NDK_HTTP_AUTH_PASSWORD')]
            );
        }

        //$configuration->setHttpCacheProvider(new \Doctrine\Common\Cache\FilesystemCache('./tmp/http/'));
        //$configuration->setReflectionCacheProvider(new \Doctrine\Common\Cache\FilesystemCache('./tmp/rc/'));
        return new Api($configuration);
    }
}