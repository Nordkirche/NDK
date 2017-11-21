<?php

namespace Nordkirche\Ndk\Domain\Model\File;

use Nordkirche\Ndk\Domain\Endpoint\ImageEndpoint;

class Image extends \Nordkirche\Ndk\Domain\Model\File\File
{

    /**
     * @var ImageEndpoint
     */
    protected $imageEndpoint;

    /**
     * @var array
     */
    protected $image;

    /**
     * @var string
     */
    protected $url;

    public function __construct(ImageEndpoint $imageEndpoint)
    {
        $this->imageEndpoint = $imageEndpoint;
    }

    /**
     * @return array
     */
    public function getImage(): array
    {
        return $this->image;
    }

    /**
     * @param array $image
     */
    public function setImage(array $image)
    {
        $this->image = $image;
    }

    /**
     * @param string|null $width
     * @param string|null $height
     *
     * @return string
     */
    public function render(string $width = null, string $height = null): string
    {
        $query = new \Nordkirche\Ndk\Domain\Query\ImageQuery($this->url);
        $width && $query->setWidth($width);
        $height && $query->setHeight($height);

        return $this->imageEndpoint->query($query);
    }
}
