<?php

namespace Nordkirche\Ndk;

use PHPUnit\Framework\TestCase;

class PerformanceTest extends TestCase
{
    use \Nordkirche\Ndk\Helper\SetupApiTrait;

    /**
     * @group e2e
     * @expectedException \Nordkirche\Ndk\Service\Exception\TimeoutException
     */
    public function testTimeoutFailing() {
        $api = $this->createApiInstance();
        $api->getConfiguration()->setRequestTimeout(0.01);
        $personRepository = $api->factory(\Nordkirche\Ndk\Domain\Repository\PersonRepository::class);
        $personRepository->getById(8066);
    }

    /**
     * @group performance
     */
    public function testPerformance() {
        $api = $this->createApiInstance();

        /** @var \Nordkirche\Ndk\Domain\Repository\PersonRepository $personRepository */
        $personRepository = $api->factory(\Nordkirche\Ndk\Domain\Repository\PersonRepository::class);

        self::assertTime($api->getConfiguration()->getRequestTimeout(), function() use ($personRepository) {
            $personRepository->getById(8066, [
                \Nordkirche\Ndk\Domain\Model\Person\Person::RELATION_ADDRESS,
                \Nordkirche\Ndk\Domain\Model\Person\Person::RELATION_DATA_ADMINISTRATOR,
                \Nordkirche\Ndk\Domain\Model\Person\Person::RELATION_FUNCTIONS
            ]);
        });
    }

    protected static function assertTime($maxTimeInSeconds, $callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('No valid callback given.');
        }

        $startTime = microtime(true);
        $callback();
        $time = microtime(true) - $startTime;

        self::assertLessThanOrEqual(
            $maxTimeInSeconds,
            $time,
            sprintf(
                'Failed asserting that execution does not need longer than %f seconds, needed %f seconds',
                $maxTimeInSeconds,
                $time
            )
        );
    }
}
