<?php

namespace ZF\OAuth2\Doctrine\MutateTableNamesTest;

use ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;

/**
 * @covers  \ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber
 */
class MutateTableNamesSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MutateTableNamesSubscriber
     */
    private $subscriber;

    public function setUp()
    {
        $this->subscriber = new MutateTableNamesSubscriber([]);
    }

    public function testSubscribesToCorrectEvents()
    {
        $this->assertSame([\Doctrine\ORM\Events::loadClassMetadata], $this->subscriber->getSubscribedEvents());
    }
}
