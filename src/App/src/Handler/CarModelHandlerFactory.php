<?php

declare(strict_types=1);

namespace App\Handler;

use function error_log;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CarModelHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        error_log('FActory hosts:'.print_r($container->get('config')['hosts'], true));

        return new CarModelHandler($template, $container->get('config')['marques'], $container->get('config')['hosts']);
    }
}
