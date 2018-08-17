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

class CarFinanceHandlerFactory
{
    public function __invoke(ContainerInterface $container) : CarFinanceHandler
    {
        return new CarFinanceHandler($container->get(TemplateRendererInterface::class));
    }
}
