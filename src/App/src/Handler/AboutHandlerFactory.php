<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types = 1);

namespace App\Handler;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class AboutHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {


        $template = $container->get(TemplateRendererInterface::class);
        return new AboutHandler($template);
    }
}
