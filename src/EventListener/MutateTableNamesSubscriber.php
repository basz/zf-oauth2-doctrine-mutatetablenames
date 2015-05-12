<?php

namespace ZF\OAuth2\Doctrine\MutateTableNames\EventListener;

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
    protected $config = array();

    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata,
        );
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var ClassMetadataInfo $metadata */
        $metadata = $eventArgs->getClassMetadata();

        switch ($metadata->getName()) {
            case $this->config['client_entity']['entity']:
                if (isset($this->config['client_entity']['primary_table'])) {
                    $metadata->setPrimaryTable($this->config['client_entity']['primary_table']);
                }
                break;

            case $this->config['access_token_entity']['entity']:
                if (isset($this->config['access_token_entity']['primary_table'])) {
                    $metadata->setPrimaryTable($this->config['access_token_entity']['primary_table']);
                }
                break;

            case $this->config['authorization_code_entity']['entity']:
                if (isset($this->config['authorization_code_entity']['primary_table'])) {
                    $metadata->setPrimaryTable($this->config['authorization_code_entity']['primary_table']);
                }
                break;

            case $this->config['refresh_token_entity']['entity']:
                if (isset($this->config['refresh_token_entity']['primary_table'])) {
                    $metadata->setPrimaryTable($this->config['refresh_token_entity']['primary_table']);
                }
                break;

            case $this->config['scope_entity']['entity']:
                if (isset($this->config['scope_entity']['primary_table'])) {
                    $metadata->setPrimaryTable($this->config['scope_entity']['primary_table']);
                }

                if (isset($this->config['scope_entity']['associations'])) {
                    foreach ($this->config['scope_entity']['associations'] as $fieldName => $association) {
                        $metadata->setAssociationOverride($fieldName, $association);
                    }
                }
                break;

            case $this->config['jwt_entity']['entity']:
                if (isset($this->config['jwt_entity']['primary_table'])) {
                    $metadata->setPrimaryTable($this->config['jwt_entity']['primary_table']);
                }
                break;

            case $this->config['jti_entity']['entity']:
                if (isset($this->config['jti_entity']['primary_table'])) {
                    $metadata->setPrimaryTable($this->config['jti_entity']['primary_table']);
                }
                break;

            case $this->config['public_key_entity']['entity']:
                if (isset($this->config['public_key_entity']['primary_table'])) {
                    $metadata->setPrimaryTable($this->config['public_key_entity']['primary_table']);
                }
                break;
        }
    }
}
