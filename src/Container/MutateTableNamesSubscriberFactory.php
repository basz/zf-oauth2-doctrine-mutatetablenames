<?php

namespace Laminas\OAuth2\Doctrine\MutateTableNames\Container;

use Interop\Container\ContainerInterface;
use Laminas\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Stdlib\ArrayUtils;

class MutateTableNamesSubscriberFactory implements FactoryInterface
{
    /**
     * Create an service
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return MutateTableNamesSubscriber
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config          = $container->get('config');
        $instanceConfigs = array_keys($config['apiskeletons-oauth2-doctrine']);
        $mapping         = [];

        foreach ($instanceConfigs as $instanceConfig) {
            if ('mutatetablenames' === $instanceConfig) {
                continue;
            }

            if (!isset($config['apiskeletons-oauth2-doctrine']['mutatetablenames'][$instanceConfig])) {
                $config['apiskeletons-oauth2-doctrine']['mutatetablenames'][$instanceConfig] = [];
            }

            $instanceMapping[$instanceConfig] = ArrayUtils::merge(
                $config['apiskeletons-oauth2-doctrine'][$instanceConfig]['dynamic_mapping'],
                $config['apiskeletons-oauth2-doctrine']['mutatetablenames'][$instanceConfig]
            );

            $mapping         = ArrayUtils::merge($instanceMapping, $mapping);
        }

        return new MutateTableNamesSubscriber($mapping);
    }

    /**
     * Create service
     *
     * for V2 compatibility
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, __CLASS__);
    }
}
