<?php

namespace Nordkirche\Ndk\Domain\Query;

use Nordkirche\Ndk\Domain\Traits\LastModifiedFilters;

class AddressQuery extends PageQuery
{
    use LastModifiedFilters;

    protected $filterProperties = [
        'id' => 'addresses',
    ];

    /**
     * @var integer[]
     */
    protected $addresses = [];

    /**
     * @return integer[]
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * @param integer[] $addresses
     *
     * @return AddressQuery
     */
    public function setAddresses(array $addresses): AddressQuery
    {
        $this->addresses = $addresses;

        return $this;
    }
}
