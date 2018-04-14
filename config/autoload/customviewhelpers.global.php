<?php

declare(strict_types=1);

use App\viewhelpers\MarqueList;
use App\viewhelpers\MarqueListFactory;

return [
    'view_helpers' => [
        'invokables' => [

        ],
        'aliases' => [
            'MarqueList' => MarqueList::class
        ],
        'factories' => [
            MarqueList::class => MarqueListFactory::class
        ]
    ]
];