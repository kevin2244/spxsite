<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ScrappageSchemesExplainedHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ScrappageSchemesExplainedHandler
    {
        $template = $container->get(TemplateRendererInterface ::class);
        return new ScrappageSchemesExplainedHandler($template);
    }
}
