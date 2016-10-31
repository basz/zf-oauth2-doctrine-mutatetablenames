<?php

namespace ZF\OAuth2\Doctrine\MutateTableNamesTest;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\OAuth2\Doctrine\MutateTableNames\Container\MutateTableNamesSubscriberFactory;
use ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;

/**
 * @covers  \ZF\OAuth2\Doctrine\MutateTableNames\Container\MutateTableNamesSubscriberFactory
 */
class MutateTableNamesSubscriberFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateFromFactory()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();

        $container->expects($this->at(0))
            ->method('get')
            ->with('config')
            ->willReturn([
                'zf-oauth2-doctrine' => [
                    'default'          => [
                        'dynamic_mapping' => []
                    ],
                    'mutatetablenames' => []
                ]
            ]);

        $factory = new MutateTableNamesSubscriberFactory();
        $service = $factory($container, 'requestedname');

        $this->assertInstanceOf(MutateTableNamesSubscriber::class, $service);
    }

    public function testCanCreateFromFactoryV2()
    {
        $container = $this->getMockBuilder(ServiceLocatorInterface::class)->getMock();

        $container->expects($this->at(0))
            ->method('get')
            ->with('config')
            ->willReturn([
                'zf-oauth2-doctrine' => [
                    'default'          => [
                        'dynamic_mapping' => []
                    ],
                    'mutatetablenames' => []
                ]
            ]);

        $factory = new MutateTableNamesSubscriberFactory();
        $service = $factory->createService($container);

        $this->assertInstanceOf(MutateTableNamesSubscriber::class, $service);
    }
}
