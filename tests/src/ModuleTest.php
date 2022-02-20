<?php

namespace ZF\OAuth2\Doctrine\MutateTableNamesTest;

use Doctrine\Common\EventManager;
use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\AutoloaderProviderInterface;
use Laminas\ModuleManager\Feature\BootstrapListenerInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\DependencyIndicatorInterface;
use Laminas\Mvc\ApplicationInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;
use ZF\OAuth2\Doctrine\MutateTableNames\Module;

/**
 * @covers  \ZF\OAuth2\Doctrine\MutateTableNames\Module
 */
class ModuleTest extends \PHPUnit\Framework\TestCase
{
    public function testAttachesEventSubscriberToDoctrineEventManager()
    {
        $module = new Module();

        $this->assertInstanceOf(BootstrapListenerInterface::class, $module);

        $event                      = $this->getMockBuilder(EventInterface::class)->getMock();
        $application                = $this->getMockBuilder(ApplicationInterface::class)->getMock();
        $serviceLocator             = $this->getMockBuilder(ServiceLocatorInterface::class)->getMock();
        $eventManager               = $this->getMockBuilder(EventManager::class)->getMock();
        $mutateTableNamesSubscriber = $this->getMockBuilder(MutateTableNamesSubscriber::class)->getMock();

        // get app mock from event
        $event->expects($this->once())->method('getParam')->with('application')->willReturn($application);

        // get service manager mock from app mock
        $application->expects($this->once())->method('getServiceManager')->willReturn($serviceLocator);

        // get config from service manager mock
        // get subscriber from service manager mock
        // get doctrine event manager mock from service locatior
        $serviceLocator->expects($this->exactly(3))
            ->method('get')
            ->withConsecutive(['config'], [MutateTableNamesSubscriber::class], ['event_manager_service_name'])
            ->willReturnOnConsecutiveCalls([
                'apiskeletons-oauth2-doctrine' => [
                    'default' => [
                        'event_manager' => 'event_manager_service_name'
                    ]
                ]
            ], $mutateTableNamesSubscriber, $eventManager);

        // add subscriber to doctrine event manager
        $eventManager->expects($this->once())
            ->method('addEventSubscriber')
            ->with($mutateTableNamesSubscriber);

        $module->onBootstrap($event);
    }

    public function testModuleAutoloading()
    {
        $module = new Module();

        $this->assertInstanceOf(AutoloaderProviderInterface::class, $module);

        $autoload = $module->getAutoloaderConfig();
        $this->assertIsArray($autoload);
        $this->assertSame(array(
            'Laminas\\Loader\\StandardAutoloader' =>
                array(
                    'namespaces' =>
                        array(
                            'ZF\\OAuth2\\Doctrine\\MutateTableNames' => realpath(__DIR__ . '/../../src'),
                        ),
                ),
        ), $autoload);
    }

    public function testModuleConfig()
    {
        $module = new Module();

        $this->assertInstanceOf(ConfigProviderInterface::class, $module);

        $this->assertIsArray($module->getConfig());
    }

    public function testModuleDependencies()
    {
        $module = new Module();

        $this->assertInstanceOf(DependencyIndicatorInterface::class, $module);

        $this->assertSame(['ApiSkeletons\OAuth2\Doctrine'], $module->getModuleDependencies());
    }
}
