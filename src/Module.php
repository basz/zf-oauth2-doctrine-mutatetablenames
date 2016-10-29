<?php

namespace ZF\OAuth2\Doctrine\MutateTableNames;

use Doctrine\Common\EventManager;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\BootstrapListenerInterface,
    Feature\ConfigProviderInterface,
    Feature\DependencyIndicatorInterface
{
    /**
     * Retrieve autoloader configuration
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ]
            ]
        ];
    }

    /**
     * Attaches an doctrine event subscriber to the configured event_manager
     *
     * @inheritdoc
     *
     * @param EventInterface $e
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $e->getParam('application')->getServiceManager();
        $config         = $serviceLocator->get('config');

        /** @var MutateTableNamesSubscriber $subscriber */
        $subscriber = $serviceLocator->get(MutateTableNamesSubscriber::class);

        /** @var EventManager $eventManager */
        $eventManager = $serviceLocator->get($config['zf-oauth2-doctrine']['default']['event_manager']);
        $eventManager->addEventSubscriber($subscriber);
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @inheritdoc
     */
    public function getModuleDependencies()
    {
        return ['ZF\OAuth2\Doctrine'];
    }
}
