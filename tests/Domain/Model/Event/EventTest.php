<?php

namespace Nordkirche\Ndk\Domain\Model\Event;

use Nordkirche\Ndk\Domain\Model\Address;
use Nordkirche\Ndk\Domain\Model\Institution\Institution;

class EventTest extends \Nordkirche\Ndk\Helper\AbstractE2eTestCase
{

    /**
     * @group e2e
     */
    public function testGetEventOrganizer()
    {
        /** @var \Nordkirche\Ndk\Service\NapiService $napiService */
        $napiService = $this->api->factory(\Nordkirche\Ndk\Service\NapiService::class);

        /** @var Event $event */
        $event = $napiService->get('events/3926');

        self::assertInstanceOf(Event::class, $event,
            'The event is not available. Please select another event to keep test running.');

        /** @var Institution $organizer */
        $organizer = $event->getChiefOrganizer();

        self::assertInstanceOf(Institution::class, $organizer);
    }

    /**
     * @group e2e
     */
    public function testGetEventAddress()
    {
        /** @var \Nordkirche\Ndk\Service\NapiService $napiService */
        $napiService = $this->api->factory(\Nordkirche\Ndk\Service\NapiService::class);

        /** @var Event $event */
        $event = $napiService->get('events/3926');

        self::assertInstanceOf(Event::class, $event,
            'The event is not available. Please select another event to keep test running.');

        /** @var Address $organizer */
        $address = $event->getAddress();

        self::assertInstanceOf(Address::class, $address);
    }

    /**
     * @group e2e
     */
    public function testGetEventFacet()
    {
        /** @var \Nordkirche\Ndk\Service\NapiService $napiService */
        $napiService = $this->api->factory(\Nordkirche\Ndk\Service\NapiService::class);

        $query = new \Nordkirche\Ndk\Domain\Query\EventQuery;

        $query->setFacets([Event::FACET_EVENT_TYPE]);

        /** @var \Nordkirche\Ndk\Service\Result */
        $events = $napiService->get('events', $query);

        self::assertArrayHasKey('event_types', $events->getFacets());
    }
}
