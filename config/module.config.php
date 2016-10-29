<?php

use ZF\OAuth2\Doctrine\MutateTableNames\Container\MutateTableNamesSubscriberFactory;
use ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;

return array(
    'zf-oauth2-doctrine' => [
        'mutatetablenames' => [],
    ],
    'service_manager'    => [
        'factories' => [
            MutateTableNamesSubscriber::class => MutateTableNamesSubscriberFactory::class,
        ],
    ],
);
