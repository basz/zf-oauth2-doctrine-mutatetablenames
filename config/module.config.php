<?php

return array(
    'zf-oauth2-doctrine-mutatetablenames' => array(
    ),
    'service_manager'                => array(
        'factories' => array(
            'ZF\OAuth2\DoctrineMutateTableNames\MutateTableNamesSubscriber'
            => 'ZF\OAuth2\DoctrineMutateTableNames\EventListener\MutateTableNamesSubscriberFactory',
        ),
    ),
);
