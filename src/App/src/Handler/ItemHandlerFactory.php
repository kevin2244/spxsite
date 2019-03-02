<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ItemHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ItemHandler
    {
        return new ItemHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(SPXGuzzleClientFactory::class)
        );
    }
}
