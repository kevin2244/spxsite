<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17/04/2018
 * Time: 01:22
 */

namespace App\Forms;

use Psr\Container\ContainerInterface;

class SearchFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new SearchForm($container->get('config')['marques']);
    }
}