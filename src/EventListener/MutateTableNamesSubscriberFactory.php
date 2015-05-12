<?php

namespace ZF\OAuth2\DoctrineMutateTableNames\EventListener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

class MutateTableNamesSubscriberFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config  = $serviceLocator->get('Config');

        $mapping = ArrayUtils::merge(
            $config['zf-oauth2-doctrine']['storage_settings']['dynamic_mapping'],
            $config['zf-oauth2-doctrine-mutatetablenames']
        );

        return new MutateTableNamesSubscriber($mapping);
    }
}
