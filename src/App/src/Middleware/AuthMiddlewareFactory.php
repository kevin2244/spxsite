<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class AuthMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthMiddleware($container->get(AuthenticationService::class));
    }
}