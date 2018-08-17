<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\Handler;

use Psr\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Expressive\Template\TemplateRendererInterface;

class LogOffHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LogOffHandler(
            $container->get(AuthenticationService::class),
            $container->get(TemplateRendererInterface::class)
        );
    }
}