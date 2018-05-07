<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 26/04/2018
 * Time: 04:24
 */

declare(strict_types=1);

namespace App\viewhelpers;

use Psr\Container\ContainerInterface;

class RouteHelperFactory
{
    /**
     * Create a RouteHelper instance.
     */
    public function __invoke(ContainerInterface $container) : RouteHelper
    {
        return $container->get(RouteHelper::class);
    }
}
