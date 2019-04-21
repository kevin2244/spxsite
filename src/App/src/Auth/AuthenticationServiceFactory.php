<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


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
