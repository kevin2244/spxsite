<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\viewhelpers;

use Psr\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;




class IdentHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new IdentHelper($container->get(AuthenticationService::class));
    }
}