<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\viewhelpers;

use Psr\Container\ContainerInterface;

class HpQuoteHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new HpQuoteHelper();
    }
}
