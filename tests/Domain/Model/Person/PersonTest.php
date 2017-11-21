<?php

namespace Nordkirche\Ndk\Domain\Model\Person;

class PersonTest extends \Nordkirche\Ndk\Helper\AbstractE2eTestCase
{

    /**
     * @todo: like some other e2e tests this should be an integration test. needs a little integration test data framework.
     * @group e2e
     */
    public function testGetFunctionType()
    {
        /** @var \Nordkirche\Ndk\Service\NapiService $napiService */
        $napiService = $this->api->factory(\Nordkirche\Ndk\Service\NapiService::class);

        /** @var Person $person */
        $person = $napiService->get('people/254');

        self::assertInstanceOf(Person::class, $person,
            'The person is not available. Please select another person to keep test running.');

        /** @var PersonFunction $function */
        $function = $person->getFunctions()->current();
        self::assertInstanceOf(PersonFunction::class, $function,
            'This person has no function. Please select another person to keep test running.');
        self::assertInstanceOf(FunctionType::class, $function->getFunctionType());
    }
}
