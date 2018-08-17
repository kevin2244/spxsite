<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\viewhelpers;

use Psr\Container\ContainerInterface;
use Zend\View\HelperPluginManager;

class MarqueListFactory
{
    public function __invoke(ContainerInterface $container)
    {
        //see https://docs.zendframework.com/zend-view/helpers/advanced-usage/
        $vcontainer = $container->get(HelperPluginManager::class);

        return new MarqueList(
            $container->get('config')['hosts'],
            $container->get('config')['marques'],
            $vcontainer->get('serverUrl'),
            $vcontainer->get('url')
        );
    }
}