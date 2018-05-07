<?php

namespace App\viewhelpers;

use Psr\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;


/**
 * User: kevin
 * Date: 02/05/2018
 * Time: 19:47
 */

class IdentHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new IdentHelper($container->get(AuthenticationService::class));
    }
}