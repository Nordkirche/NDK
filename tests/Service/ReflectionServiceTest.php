<?php

namespace Nordkirche\Ndk\Service;

use Nordkirche\Ndk\Configuration;
use Nordkirche\Ndk\Helper\MockModel;
use phpDocumentor\Reflection\DocBlockFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class ReflectionServiceTest extends TestCase
{

    /**
     * @group unit
     */
    public function testExpectedTypeIsStoredInPsr6Pool()
    {
        $pool = new ArrayAdapter();
        $configuration = (new Configuration(1, 'foobar'))->setReflectionCacheProvider($pool);
        $testSubject = new ReflectionService(DocBlockFactory::createInstance(), new CacheService($configuration));

        $expected = ['string', true, null];

        self::assertSame($expected, $testSubject->returnExpectedType(new MockModel(), 'setString'));
        self::assertCount(1, $pool->getValues());
        self::assertSame($expected, $testSubject->returnExpectedType(new MockModel(), 'setString'));
    }

    /**
     * @group unit
     */
    public function testCachedTypeIsReturnedWithoutReflection()
    {
        $pool = new ArrayAdapter();
        $configuration = (new Configuration(1, 'foobar'))->setReflectionCacheProvider($pool);
        $testSubject = new ReflectionService(DocBlockFactory::createInstance(), new CacheService($configuration));

        $testSubject->returnExpectedType(new MockModel(), 'setString');
        $key = array_key_first($pool->getValues());
        $pool->save($pool->getItem($key)->set(['from-cache', false, null]));

        self::assertSame(['from-cache', false, null], $testSubject->returnExpectedType(new MockModel(), 'setString'));
    }
}
