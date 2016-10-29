<?php

namespace ZF\OAuth2\Doctrine\MutateTableNamesTest;

use Doctrine\Common\EventManager;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
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

        $event                      = $this->createMock(EventInterface::class);
        $application                = $this->createMock(ApplicationInterface::class);
        $serviceLocator             = $this->createMock(ServiceLocatorInterface::class);
        $eventManager               = $this->createMock(EventManager::class);
        $mutateTableNamesSubscriber = $this->createMock(MutateTableNamesSubscriber::class);

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
}
