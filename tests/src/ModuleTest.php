<?php

namespace ZF\OAuth2\Doctrine\MutateTableNamesTest;

use Doctrine\Common\EventManager;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\Mvc\ApplicationInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;
use ZF\OAuth2\Doctrine\MutateTableNames\Module;

/**
 * @covers  \ZF\OAuth2\Doctrine\MutateTableNames\Module
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testAttachesEventSubscriberToDoctrineEventManager()
    {
        $module = new Module();

        $this->assertInstanceOf(BootstrapListenerInterface::class, $module);

        $event                      = $this->getMock(EventInterface::class);
        $application                = $this->getMock(ApplicationInterface::class);
        $serviceLocator             = $this->getMock(ServiceLocatorInterface::class);
        $eventManager               = $this->getMock(EventManager::class);
        $mutateTableNamesSubscriber = $this->getMock(MutateTableNamesSubscriber::class);

        // get app mock from event
        $event->expects($this->once())->method('getParam')->with('application')->willReturn($application);

        // get service manager mock from app mock
        $application->expects($this->once())->method('getServiceManager')->willReturn($serviceLocator);

        // get config from service manager mock
        $serviceLocator->expects($this->at(0))
            ->method('get')
            ->with('config')
            ->willReturn([
                'zf-oauth2-doctrine' => [
                    'default' => [
                        'event_manager' => 'event_manager_service_name'
                    ]
                ]
            ]);

        // get subscriber from service manager mock
        $serviceLocator->expects($this->at(1))
            ->method('get')
            ->with(MutateTableNamesSubscriber::class)
            ->willReturn($mutateTableNamesSubscriber);

        // get doctrine event manager mock from service locatior
        $serviceLocator->expects($this->at(2))
            ->method('get')
            ->with('event_manager_service_name')
            ->willReturn($eventManager);

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
        $this->assertInternalType('array', $autoload);
        $this->assertSame(array(
            'Zend\\Loader\\StandardAutoloader' =>
                array(
                    'namespaces' =>
                        array(
                            'ZF\\OAuth2\\Doctrine\\MutateTableNames' => '/Users/bas/Sandbox/zf-oauth2-doctrine-mutatetablenames/src',
                        ),
                ),
        ), $autoload);
    }

    public function testModuleConfig()
    {
        $module = new Module();

        $this->assertInstanceOf(ConfigProviderInterface::class, $module);

        $this->assertInternalType('array', $module->getConfig());
    }

    public function testModuleDependencies()
    {
        $module = new Module();

        $this->assertInstanceOf(DependencyIndicatorInterface::class, $module);

        $this->assertSame(['ZF\OAuth2\Doctrine'], $module->getModuleDependencies());
    }
}
