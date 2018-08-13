<?php
declare(strict_types=1);
/**
 * User: kevin
 * Date: 03/05/2018
 * Time: 11:00
 */

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