<?php

namespace Nordkirche\Ndk\Service\Interfaces;

interface ResourceObjectInterface
{

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $id
     */
    public function setId(string $id);

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     */
    public function setType(string $type);

    /**
     * Returns the object as a NAPI URL
     *
     * napi://identifier/id
     *
     * @return string
     */
    public function __toString();
}
