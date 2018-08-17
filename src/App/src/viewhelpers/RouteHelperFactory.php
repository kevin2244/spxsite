<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\viewhelpers;

use Psr\Container\ContainerInterface;

class RouteHelperFactory
{
    public function __invoke(ContainerInterface $container) : RouteHelper
    {
        return $container->get(RouteHelper::class);
    }
}
