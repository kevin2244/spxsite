<?php

declare(strict_types=1);

use App\viewhelpers\IdentHelper;
use App\viewhelpers\IdentHelperFactory;
use App\viewhelpers\RouteHelperFactory;
use App\viewhelpers\MarqueList;
use App\viewhelpers\MarqueListFactory;
use App\viewhelpers\RouteHelper;
use App\viewhelpers\LogOnOffToggleHelper;
use App\viewhelpers\LogOnOffToggleHelperFactory;


return [
    'view_helpers' => [
        'invokables' => [

        ],
        'aliases' => [
            'MarqueList' => MarqueList::class,
            'routeHelper' => RouteHelper::class,
            'IdentHelper' => IdentHelper::class,
            'LogOnOffToggleHelper' => LogOnOffToggleHelper::class
        ],
        'factories' => [
            MarqueList::class => MarqueListFactory::class,
            RouteHelper::class => RouteHelperFactory::class,
            IdentHelper::class => IdentHelperFactory::class,
            LogOnOffToggleHelper::class => LogOnOffToggleHelperFactory::class
        ]
    ]
];