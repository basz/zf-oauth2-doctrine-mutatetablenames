<?php

namespace ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class MutateTableNamesSubscriber implements EventSubscriber
{
    /**
     * Contains config
     *
     * @var array
     */
    protected $config = [];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var ClassMetadataInfo $metadata */
        $metadata = $eventArgs->getClassMetadata();

        $instanceConfigs = array_keys($this->config);

        foreach ($instanceConfigs as $instanceConfig) {
            $config = $this->config[$instanceConfig];
            switch ($metadata->getName()) {
                case $config['client_entity']['entity']:
                    if (isset($config['client_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($config['client_entity']['primary_table']);
                    }
                    break;

                case $config['access_token_entity']['entity']:
                    if (isset($config['access_token_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($config['access_token_entity']['primary_table']);
                    }
                    break;

                case $config['authorization_code_entity']['entity']:
                    if (isset($config['authorization_code_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($config['authorization_code_entity']['primary_table']);
                    }
                    break;

                case $config['refresh_token_entity']['entity']:
                    if (isset($config['refresh_token_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($config['refresh_token_entity']['primary_table']);
                    }
                    break;

                case $config['scope_entity']['entity']:
                    if (isset($config['scope_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($config['scope_entity']['primary_table']);
                    }

                    if (isset($config['scope_entity']['associations'])) {
                        foreach ($config['scope_entity']['associations'] as $fieldName => $association) {
                            $metadata->setAssociationOverride($fieldName, $association);
                        }
                    }
                    break;

                case $config['jwt_entity']['entity']:
                    if (isset($config['jwt_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($config['jwt_entity']['primary_table']);
                    }
                    break;

                case $config['jti_entity']['entity']:
                    if (isset($config['jti_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($config['jti_entity']['primary_table']);
                    }
                    break;

                case $config['public_key_entity']['entity']:
                    if (isset($config['public_key_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($config['public_key_entity']['primary_table']);
                    }
                    break;
            }
        }
    }
}
