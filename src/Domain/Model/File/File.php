<?php

namespace Nordkirche\Ndk\Domain\Model\File;

class File extends \Nordkirche\Ndk\Domain\Model\AbstractModel
{
            
    /**
     * @var string
     */
    protected $fileName;
            
    /**
     * @var Details
     */
    protected $details;
            
    /**
     * @var string
     */
    protected $mimeType;

    /**
     * @var string
     */
    protected $simpleMimeType;
            
    /**
     * @var integer
     */
    protected $size;
            
    /**
     * @var string
     */
    protected $title;
            
    /**
     * @var string
     */
    protected $url;
        
    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
    
    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return Details
     */
    public function getDetails(): Details
    {
        return $this->details;
    }

    /**
     * @param Details $details
     */
    public function setDetails(Details $details)
    {
        $this->details = $details;
    }
        
    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }
    
    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getSimpleMimeType(): string
    {
        $parts = explode('/', $this->getMimeType());
        return sizeof($parts) ? $parts[1] : $this->getMimeType();
    }

    /**
     * @param string $simpleMimeType
     */
    public function setSimpleMimeType(string $simpleMimeType)
    {
        $this->simpleMimeType = $simpleMimeType;
    }

    /**
     * @return integer
     */
    public function getSize(): int
    {
        return $this->size;
    }
    
    /**
     * @param integer $size
     */
    public function setSize(int $size)
    {
        $this->size = $size;
    }
        
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @param string $title
     */
    public function setTitle(string $title = null)
    {
        $this->title = $title;
    }
        
    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
    
    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }
}
