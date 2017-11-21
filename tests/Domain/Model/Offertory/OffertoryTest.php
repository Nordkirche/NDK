<?php

namespace Nordkirche\Ndk\Domain\Model\Offertory;

use Nordkirche\Ndk\Domain\Model\Person\Person;
use Nordkirche\Ndk\Domain\Model\Institution\Institution;

class OffertoryTest extends \Nordkirche\Ndk\Helper\AbstractE2eTestCase
{

    /**
     * @group e2e
     */
    public function testGetOfferoryInstitution()
    {
        /** @var \Nordkirche\Ndk\Service\NapiService $napiService */
        $napiService = $this->api->factory(\Nordkirche\Ndk\Service\NapiService::class);

        /** @var Offertory $offertory */
        $offertory = $napiService->get('offertories/1');

        self::assertInstanceOf(Offertory::class, $offertory,
            'The offertory project is not available. Please select another project to keep test running.');

        /** @var Institution $institution */
        $institution = $offertory->getInstitution();

        self::assertInstanceOf(Institution::class, $institution);
    }

    /**
     * @group e2e
     */
    public function testGetOfferoryPerson()
    {
        /** @var \Nordkirche\Ndk\Service\NapiService $napiService */
        $napiService = $this->api->factory(\Nordkirche\Ndk\Service\NapiService::class);

        /** @var Offertory $offertory */
        $offertory = $napiService->get('offertories/1');

        self::assertInstanceOf(Offertory::class, $offertory,
            'The offertory project is not available. Please select another project to keep test running.');

        /** @var Persin $person */
        $person = $offertory->getPerson();

        self::assertInstanceOf(Person::class, $person);
    }


}