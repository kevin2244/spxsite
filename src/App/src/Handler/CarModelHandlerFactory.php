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
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CarModelHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        return new CarModelHandler(
            $container->get(SPXGuzzleClientFactory::class),
            $container->get(TemplateRendererInterface::class),
            $container->get('config')['marques']
        );
    }
}
