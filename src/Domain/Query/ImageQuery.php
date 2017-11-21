<?php

namespace Nordkirche\Ndk\Domain\Query;

class ImageQuery implements \Nordkirche\Ndk\Service\Interfaces\QueryInterface
{

    /**
     * @var integer
     */
    protected $id = 0;

    /**
     * @var string
     */
    protected $width = '';

    /**
     * @var string
     */
    protected $height = '';

    public function __construct(string $url = null)
    {
        if ($url === null) {
            return ;
        }

        $parsedUrl = parse_url($url);

        $path = explode('/', $parsedUrl['path']);
        $sizeof = sizeof($path);

        if ($sizeof > 2 && $path[$sizeof-2] === 'images' && is_numeric($id = $path[$sizeof-1])) {
            $this->id = $id;
        } else {
            throw new \InvalidArgumentException('The given url is not a valid url for an image query', 1502130522);
        }
    }

    public function returnUrlParameters(): array
    {
        $this->enforceImageId();

        $param = [];

        if ($this->width !== '') {
            $param['w'] = $this->width;
        }
        if ($this->height !== '') {
            $param['h'] = $this->height;
        }

        return $param;
    }

    private function enforceImageId()
    {
        if ($this->id === 0) {
            throw new \Exception('You need to set an image ID.', 1501261054);
        }
    }

    public function __toString(): string
    {
        $this->enforceImageId();
        $query = '';

        if ((bool)($param = $this->returnUrlParameters())) {
            $query = '?'.http_build_query($param);
        }

        $string = '/' . $this->id . $query;

        return $string;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ImageQuery
     */
    public function setId(int $id): ImageQuery
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getWidth(): string
    {
        return $this->width;
    }

    /**
     * @param string $width
     *
     * @return ImageQuery
     */
    public function setWidth(string $width): ImageQuery
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeight(): string
    {
        return $this->height;
    }

    /**
     * @param string $height
     *
     * @return ImageQuery
     */
    public function setHeight(string $height): ImageQuery
    {
        $this->height = $height;

        return $this;
    }
}
