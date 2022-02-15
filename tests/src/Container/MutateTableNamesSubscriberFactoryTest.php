<?php

namespace Laminas\OAuth2\Doctrine\MutateTableNamesTest;

use Interop\Container\ContainerInterface;
use Laminas\OAuth2\Doctrine\MutateTableNames\Container\MutateTableNamesSubscriberFactory;
use Laminas\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * @covers  \Laminas\OAuth2\Doctrine\MutateTableNames\Container\MutateTableNamesSubscriberFactory
 */
class MutateTableNamesSubscriberFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCanCreateFromFactory()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();

        $container->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn([
                'apiskeletons-oauth2-doctrine' => [
                    'default'          => [
                        'dynamic_mapping' => []
                    ],
                    'mutatetablenames' => [
                        'default' => []
                    ]
                ]
            ]);

        $factory = new MutateTableNamesSubscriberFactory();
        $service = $factory($container, 'requestedname');

        $this->assertInstanceOf(MutateTableNamesSubscriber::class, $service);
    }

    public function testCanCreateFromFactoryV2()
    {
        $container = $this->getMockBuilder(ServiceLocatorInterface::class)->getMock();

        $container->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn([
                'apiskeletons-oauth2-doctrine' => [
                    'default'          => [
                        'dynamic_mapping' => []
                    ],
                    'mutatetablenames' => [
                        'default' => []
                    ]
                ]
            ]);

        $factory = new MutateTableNamesSubscriberFactory();
        $service = $factory->createService($container);

        $this->assertInstanceOf(MutateTableNamesSubscriber::class, $service);
    }

    public function testOmittedServiceKeyIsNot()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();

        $container->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn([
                'apiskeletons-oauth2-doctrine' => [
                    'default'          => [
                        'dynamic_mapping' => []
                    ],
                    'non-default'          => [
                        'dynamic_mapping' => []
                    ],
                    'mutatetablenames' => [
                        'default' => [],
                        // 'non-default' omitted on purpose
                    ]
                ]
            ]);

        $factory = new MutateTableNamesSubscriberFactory();
        $service = $factory($container, 'requestedname');

        $this->assertInstanceOf(MutateTableNamesSubscriber::class, $service);
    }
}
