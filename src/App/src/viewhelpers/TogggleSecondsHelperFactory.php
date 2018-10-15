<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\viewhelpers;

use Psr\Container\ContainerInterface;

class TogggleSecondsHelperFactory
{
    public function __invoke(ContainerInterface $container) : ToggleSecondsHelper
    {
        return new ToggleSecondsHelper($container->get('config')['show_seconds']);
    }
}
