<?php
/**
 * User: kevin
 * Date: 01/05/2018
 * Time: 17:08
 */

namespace App\Auth;

use Psr\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class AuthenticationServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthenticationService(
            null,
            $container->get(AuthAdapter::class)
        );
    }
}