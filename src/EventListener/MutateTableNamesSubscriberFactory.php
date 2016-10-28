<?php

namespace ZF\OAuth2\Doctrine\MutateTableNames\EventListener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

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
        $config = $container->get('config');

        $mapping = ArrayUtils::merge(
            $config['zf-oauth2-doctrine']['default']['dynamic_mapping'],
            $config['zf-oauth2-doctrine']['mutatetablenames']
        );

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
