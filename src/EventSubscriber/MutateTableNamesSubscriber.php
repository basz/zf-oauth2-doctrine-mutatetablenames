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

            switch ($metadata->getName()) {
                case $this->config[$instanceConfig]['client_entity']['entity']:
                    if (isset($this->config[$instanceConfig]['client_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($this->config[$instanceConfig]['client_entity']['primary_table']);
                    }
                    break;

                case $this->config[$instanceConfig]['access_token_entity']['entity']:
                    if (isset($this->config[$instanceConfig]['access_token_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($this->config[$instanceConfig]['access_token_entity']['primary_table']);
                    }
                    break;

                case $this->config[$instanceConfig]['authorization_code_entity']['entity']:
                    if (isset($this->config[$instanceConfig]['authorization_code_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($this->config[$instanceConfig]['authorization_code_entity']['primary_table']);
                    }
                    break;

                case $this->config[$instanceConfig]['refresh_token_entity']['entity']:
                    if (isset($this->config[$instanceConfig]['refresh_token_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($this->config[$instanceConfig]['refresh_token_entity']['primary_table']);
                    }
                    break;

                case $this->config[$instanceConfig]['scope_entity']['entity']:
                    if (isset($this->config[$instanceConfig]['scope_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($this->config[$instanceConfig]['scope_entity']['primary_table']);
                    }

                    if (isset($this->config[$instanceConfig]['scope_entity']['associations'])) {
                        foreach ($this->config[$instanceConfig]['scope_entity']['associations'] as $fieldName => $association) {
                            $metadata->setAssociationOverride($fieldName, $association);
                        }
                    }
                    break;

                case $this->config[$instanceConfig]['jwt_entity']['entity']:
                    if (isset($this->config[$instanceConfig]['jwt_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($this->config[$instanceConfig]['jwt_entity']['primary_table']);
                    }
                    break;

                case $this->config[$instanceConfig]['jti_entity']['entity']:
                    if (isset($this->config[$instanceConfig]['jti_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($this->config[$instanceConfig]['jti_entity']['primary_table']);
                    }
                    break;

                case $this->config[$instanceConfig]['public_key_entity']['entity']:
                    if (isset($this->config[$instanceConfig]['public_key_entity']['primary_table'])) {
                        $metadata->setPrimaryTable($this->config[$instanceConfig]['public_key_entity']['primary_table']);
                    }
                    break;
            }
        }
    }
}
