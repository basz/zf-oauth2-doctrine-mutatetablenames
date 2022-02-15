<?php

namespace Laminas\OAuth2\Doctrine\MutateTableNames;

use Doctrine\Common\EventManager;
use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature;
use Laminas\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;
use Laminas\ServiceManager\ServiceLocatorInterface;

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
            'Laminas\Loader\StandardAutoloader' => [
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
        $eventManager = $serviceLocator->get($config['apiskeletons-oauth2-doctrine']['default']['event_manager']);
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
        return ['ApiSkeletons\OAuth2\Doctrine'];
    }
}
