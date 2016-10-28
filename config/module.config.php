<?php

return array(
    'zf-oauth2-doctrine' => [
        'mutatetablenames' => [],
    ],
    'service_manager'    => [
        'factories' => [
            'ZF\OAuth2\Doctrine\MutateTableNames\MutateTableNamesSubscriber'
            => 'ZF\OAuth2\Doctrine\MutateTableNames\EventListener\MutateTableNamesSubscriberFactory',
        ],
    ],
);
