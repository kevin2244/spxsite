<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 27/04/2018
 * Time: 02:48
 */

namespace App\Middleware;

use App\viewhelpers\RouteHelper;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Helper\Exception;

class RouterHelperMiddlewareFactory
{
    /**
     * Create and return a RouteHelperMiddleware instance
     *
     * @param ContainerInterface $container
     *
     * @throws Exception\MissingHelperException if the Route helper Service is
     *         missing
     *
     * @return RouteHelperMiddleware
     */
    public function __invoke(ContainerInterface $container) : RouteHelperMiddleware
    {
        if (!$container->has(RouteHelper::class)) {
            throw new Exception\MissingHelperException(sprintf(
                '%s requires a %s service at instantiation; none found',
                RouteHelperMiddleware::class,
                RouteHelper::class
            ));
        }
        return new RouteHelperMiddleware($container->get(RouteHelper::class));
    }
}