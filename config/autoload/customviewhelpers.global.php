<?php

declare(strict_types=1);

use App\viewhelpers\RouteHelperFactory;
use App\viewhelpers\MarqueList;
use App\viewhelpers\MarqueListFactory;
use App\viewhelpers\RouteHelper;


return [
    'view_helpers' => [
        'invokables' => [

        ],
        'aliases' => [
            'MarqueList' => MarqueList::class,
            'routeHelper' => RouteHelper::class
        ],
        'factories' => [
            MarqueList::class => MarqueListFactory::class,
            RouteHelper::class => RouteHelperFactory::class
        ]
    ]
];