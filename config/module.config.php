<?php

use ZF\OAuth2\Doctrine\MutateTableNames\Container\MutateTableNamesSubscriberFactory;
use ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;

return array(
    'apiskeletons-oauth2-doctrine' => [
        'mutatetablenames' => [
            'default' => []
        ],
    ],
    'service_manager'    => [
        'factories' => [
            MutateTableNamesSubscriber::class => MutateTableNamesSubscriberFactory::class,
        ],
    ],
);
