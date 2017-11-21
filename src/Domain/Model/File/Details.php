<?php

namespace Nordkirche\Ndk\Domain\Model\File;

class Details implements \Nordkirche\Ndk\Domain\Interfaces\ModelInterface
{

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $alternative;

    /**
     * @var string
     */
    protected $caption;

    /**
     * @var string
     */
    protected $license;

    /**
     * @var string
     */
    protected $copyright;

    /**
     * @var string
     */
    protected $relatedFiles;

    /**
     * @var string
     */
    protected $licenseVersion;

    /**
     * @var string
     */
    protected $copyrightUrl;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description = null)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getAlternative()
    {
        return $this->alternative;
    }

    /**
     * @param string $alternative
     */
    public function setAlternative(string $alternative = null)
    {
        $this->alternative = $alternative;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     */
    public function setCaption(string $caption = null)
    {
        $this->caption = $caption;
    }

    /**
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @param string $license
     */
    public function setLicense(string $license = null)
    {
        $this->license = $license;
    }

    /**
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @param string $copyright
     */
    public function setCopyright(string $copyright = null)
    {
        $this->copyright = $copyright;
    }

    /**
     * @return string
     */
    public function getRelatedFiles()
    {
        return $this->relatedFiles;
    }

    /**
     * @param string $relatedFiles
     */
    public function setRelatedFiles(string $relatedFiles = null)
    {
        $this->relatedFiles = $relatedFiles;
    }

    /**
     * @return string
     */
    public function getLicenseVersion()
    {
        return $this->licenseVersion;
    }

    /**
     * @param string $licenseVersion
     */
    public function setLicenseVersion(string $licenseVersion = null)
    {
        $this->licenseVersion = $licenseVersion;
    }

    /**
     * @return string
     */
    public function getCopyrightUrl()
    {
        return $this->copyrightUrl;
    }

    /**
     * @param string $copyrightUrl
     */
    public function setCopyrightUrl(string $copyrightUrl = null)
    {
        $this->copyrightUrl = $copyrightUrl;
    }
}
