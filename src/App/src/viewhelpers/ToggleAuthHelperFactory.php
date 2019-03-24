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

class ToggleAuthHelperFactory
{
    public function __invoke(ContainerInterface $container) : ToggleAuthHelper
    {
        return new ToggleAuthHelper(
            $container->get(AuthenticationService::class)
        );
    }
}
