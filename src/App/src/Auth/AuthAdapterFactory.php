<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 01/05/2018
 * Time: 17:01
 */

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