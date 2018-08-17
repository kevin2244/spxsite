<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\Auth;

use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;

class AuthAdapterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthAdapter($container->get(SPXGuzzleClientFactory::class));
    }
}