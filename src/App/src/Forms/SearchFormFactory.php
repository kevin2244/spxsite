<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17/04/2018
 * Time: 01:22
 */

namespace App\Forms;
use App\Model\MarqueList;

use Psr\Container\ContainerInterface;

class SearchFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new SearchForm($container->get(MarqueList::class)->getMarqueList($container));
    }
}