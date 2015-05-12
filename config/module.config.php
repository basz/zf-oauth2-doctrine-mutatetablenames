<?php

return array(
    'zf-oauth2-doctrine' => array(
        'mutatetablenames' => array(),
    ),
    'service_manager'    => array(
        'factories' => array(
            'ZF\OAuth2\Doctrine\MutateTableNames\MutateTableNamesSubscriber'
            => 'ZF\OAuth2\Doctrine\MutateTableNames\EventListener\MutateTableNamesSubscriberFactory',
        ),
    ),
);
