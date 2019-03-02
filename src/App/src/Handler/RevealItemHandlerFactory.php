<?php

declare(strict_types=1);

namespace App\Handler;

use App\Helpers\IdentHelper;
use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;

class RevealItemHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RevealItemHandler
    {

        return new RevealItemHandler(
            $container->get(SPXGuzzleClientFactory::class),
            $container->get(IdentHelper::class)
        );
    }
}
