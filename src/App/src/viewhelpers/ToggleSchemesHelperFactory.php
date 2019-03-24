<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\viewhelpers;

use Psr\Container\ContainerInterface;

class ToggleSchemesHelperFactory
{
    public function __invoke(ContainerInterface $container) : ToggleSchemesHelper
    {
        return new ToggleSchemesHelper(
            $container->get('config')['show_schemes']
        );
    }
}
