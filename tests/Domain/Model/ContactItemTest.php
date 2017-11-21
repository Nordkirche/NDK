<?php

namespace Nordkirche\Ndk\Domain\Model;

use Nordkirche\Ndk\Helper\AbstractIntegrationTestCase;

class ContactItemTest extends AbstractIntegrationTestCase
{

    /**
     * @var ContactItem
     */
    protected $fixture;

    public function setUp()
    {
        parent::setUp();
        $this->fixture = $this->api->factory()->make(ContactItem::class);
    }

    /**
     * @group integration
     */
    public function testDecorating()
    {
        $valueArray = [
            'id' => 1,
            'type' => 'Telefon',
            'value' => '+49 123 456 789'
        ];

        /** @var \Nordkirche\Ndk\Service\ModelDecoratorService $decorator */
        $decorator = $this->api->factory(\Nordkirche\Ndk\Service\ModelDecoratorService::class);
        $decorator->decorateObject($this->fixture, $valueArray);

        self::assertEquals($valueArray['type'], $this->fixture->getType());
        self::assertEquals($valueArray['value'], $this->fixture->getValue());
    }
}
