<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;

class RemoveItemHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RemoveItemHandler
    {
        return new RemoveItemHandler(
            $container->get(SPXGuzzleClientFactory::class)
        );
    }
}
