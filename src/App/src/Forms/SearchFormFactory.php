<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


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