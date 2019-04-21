<?php

declare(strict_types=1);

namespace App\Handler;

use App\Helpers\IdentHelper;
use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class MyItemListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : MyItemListHandler
    {
        return new MyItemListHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(SPXGuzzleClientFactory::class),
            $container->get(IdentHelper::class)
        );
    }
}
