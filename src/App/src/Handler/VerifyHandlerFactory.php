<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Handler;

use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class VerifyHandlerFactory
{
    public function __invoke(ContainerInterface $container) : VerifyHandler
    {
        return new VerifyHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(SPXGuzzleClientFactory::class)
        );
    }
}
