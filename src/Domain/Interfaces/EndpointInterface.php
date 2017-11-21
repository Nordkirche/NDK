<?php

namespace Nordkirche\Ndk\Domain\Interfaces;

interface EndpointInterface
{

    /**
     * @param $query \Nordkirche\Ndk\Service\Interfaces\QueryInterface
     *
     * @return \Nordkirche\Ndk\Service\Result
     */
    public function query($query = null);
}
