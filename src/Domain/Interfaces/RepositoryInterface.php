<?php

namespace Nordkirche\Ndk\Domain\Interfaces;

use Nordkirche\Ndk\Service\Result;

interface RepositoryInterface
{

    /**
     * @param \Nordkirche\Ndk\Service\Interfaces\QueryInterface $query
     *
     * @return Result|null
     */
    public function get($query = null);

    /**
     * @param int $id
     * @param string[] $include Array with fields to include
     *
     * @return ModelInterface|null
     */
    public function getById(int $id, array $include);
}
