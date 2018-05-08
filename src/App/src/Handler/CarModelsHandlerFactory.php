<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CarModelsHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $template = $container->get(TemplateRendererInterface::class);
        return new CarModelsHandler($template, $container->get('config')['marques'],$container->get(SPXGuzzleClientFactory::class));
    }
}
