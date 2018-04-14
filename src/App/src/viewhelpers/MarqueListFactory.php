<?php

namespace App\viewhelpers;

use Zend\ServiceManager\AbstractPluginManager;

use Zend\View\HelperPluginManager;

class MarqueListFactory
{
    public function __invoke($container)
    {
        if (!$container instanceof AbstractPluginManager) {

            //see https://docs.zendframework.com/zend-view/helpers/advanced-usage/
            $vcontainer = $container->get(HelperPluginManager::class);
        }

        return new MarqueList(
            $container->get('config')['hosts'],
            $container->get('config')['marques'],
            $vcontainer->get('serverUrl'),
            $vcontainer->get('url')
        );
    }
}