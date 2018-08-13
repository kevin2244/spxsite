<?php
declare(strict_types=1);
/**
 * User: kevin
 * Date: 01/05/2018
 * Time: 23:23
 */

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