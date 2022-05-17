<?php

namespace Nordkirche\Ndk\Domain\Model;

use Nordkirche\Ndk\Helper\AbstractIntegrationTestCase;

class ResourcePlaceholderTest extends AbstractIntegrationTestCase
{

    /**
     * @var $testSubject ResourcePlaceholder
     */
    protected $testSubject;

    public function setUp(): void
    {
        parent::setUp();

        $this->testSubject = new ResourcePlaceholder();
        $this->testSubject->setId(1);
        $this->testSubject->setType('type');
    }

    /**
     * @group integration
     */
    public function testGetLabel()
    {
        self::assertEquals('type:1', $this->testSubject->getLabel());

        $this->api->getConfiguration()->setPlaceholderLabelClosure(function(ResourcePlaceholder $placeholder) {
            return 'Foobar';
        });

        self::assertEquals('Foobar', $this->testSubject->getLabel());
    }

}
