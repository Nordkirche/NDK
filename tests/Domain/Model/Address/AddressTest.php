<?php

namespace Nordkirche\Ndk\Domain\Model;

use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{

    /**
     * @var $testSubject Address
     */
    protected $testSubject;

    public function setUp()
    {
        parent::setUp();
        /** @var $decoratorMock \Nordkirche\Ndk\Service\ModelDecoratorService */
        $decoratorMock = $this->getMockBuilder(\Nordkirche\Ndk\Service\ModelDecoratorService::class)
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->testSubject = new Address($decoratorMock);
    }

    /**
     * @group unit
     */
    public function testGetLabelWithAddress()
    {
        $this->testSubject->setStreet('Some Street 123');
        $this->testSubject->setZipCode('24013');
        $this->testSubject->setCity('Kiel');
        $this->testSubject->setCountry('DE');

        $this->assertEquals('Some Street 123, 24013, Kiel, DE', $this->testSubject->getLabel());
    }

    /**
     * @group unit
     */
    public function testGetLabelWithPo()
    {
        $this->testSubject->setPoBox('12345');
        $this->testSubject->setPoBoxZipCode('24013');
        $this->testSubject->setCity('Kiel');
        $this->testSubject->setCountry('DE');

        $this->assertEquals('PO 12345, 24013, Kiel, DE', $this->testSubject->getLabel());
    }
}
