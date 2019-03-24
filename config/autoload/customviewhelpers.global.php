<?php

declare(strict_types=1);

use App\viewhelpers\HpQuoteHelper;
use App\viewhelpers\HpQuoteHelperFactory;
use App\viewhelpers\IdentHelper;
use App\viewhelpers\IdentHelperFactory;
use App\viewhelpers\LogOnOffToggleHelper;
use App\viewhelpers\LogOnOffToggleHelperFactory;
use App\viewhelpers\MarqueList;
use App\viewhelpers\MarqueListFactory;
use App\viewhelpers\RouteHelper;
use App\viewhelpers\RouteHelperFactory;
use App\viewhelpers\TogggleSecondsHelperFactory;
use App\viewhelpers\ToggleAuthHelper;
use App\viewhelpers\ToggleAuthHelperFactory;
use App\viewhelpers\ToggleSchemesHelper;
use App\viewhelpers\ToggleSchemesHelperFactory;
use App\viewhelpers\ToggleSecondsHelper;



return [
    'view_helpers' => [
        'invokables' => [
        ],
        'aliases' => [
            'MarqueList' => MarqueList::class,
            'routeHelper' => RouteHelper::class,
            'IdentHelper' => IdentHelper::class,
            'LogOnOffToggleHelper' => LogOnOffToggleHelper::class,
            'ToggleSecondsHelper' => ToggleSecondsHelper::class,
            'HpQuoteHelper' => HpQuoteHelper::class,
            'ToggleAuthHelper' => ToggleAuthHelper::class,
            'ToggleSchemesHelper' => ToggleSchemesHelper::class
        ],
        'factories' => [
            MarqueList::class => MarqueListFactory::class,
            RouteHelper::class => RouteHelperFactory::class,
            IdentHelper::class => IdentHelperFactory::class,
            LogOnOffToggleHelper::class => LogOnOffToggleHelperFactory::class,
            ToggleSecondsHelper::class => TogggleSecondsHelperFactory::class,
            HpQuoteHelper::class => HpQuoteHelperFactory::class,
            ToggleAuthHelper::class => ToggleAuthHelperFactory::class,
            ToggleSchemesHelper::class => ToggleSchemesHelperFactory::class
        ]
    ]
];