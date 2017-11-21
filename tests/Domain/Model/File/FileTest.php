<?php

namespace Nordkirche\Ndk\Domain\Model\File;

class FileTest extends \Nordkirche\Ndk\Helper\AbstractIntegrationTestCase
{

    protected $fixture = [
        "file_name" => "testfile.jpg",
        "mime_type" => "image/jpeg",
        "size" => 133576,
        "title" => "Test Image",
        "url" => "http://someurl/testfile.jpg",
        "details" => [
            "description" => "Description",
            "alternative" => "Alternative",
            "caption" => "Caption",
            "license" => "License",
            "copyright" => "Copyright",
            "related_files" => "testfile2.jpg",
            "license_version" => null,
            "copyright_url" => null
        ]
    ];

    /**
     * @group integration
     */
    public function testDecorate()
    {
        /** @var \Nordkirche\Ndk\Service\ModelDecoratorService $decoratorService */
        $decoratorService = $this->api->factory(\Nordkirche\Ndk\Service\ModelDecoratorService::class);

        /** @var File $fileObject */
        $fileObject = $decoratorService->decorateObject(new File(), $this->fixture);

        self::assertEquals($this->fixture['file_name'], $fileObject->getFileName());
        self::assertEquals($this->fixture['size'], $fileObject->getSize());
        self::assertInstanceOf(Details::class, $fileObject->getDetails());
        self::assertEquals($this->fixture['details']['description'], $fileObject->getDetails()->getDescription());
        self::assertEquals($this->fixture['details']['license_version'], $fileObject->getDetails()->getLicenseVersion());
    }
}
