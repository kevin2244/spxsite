<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;

class RemovePhotoHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RemovePhotoHandler
    {
        return new RemovePhotoHandler(
            $container->get(SPXGuzzleClientFactory::class)
        );
    }
}
