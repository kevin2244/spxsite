<?php
declare(strict_types=1);

namespace App\viewhelpers;

use Psr\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\View\HelperPluginManager;
/**
 * User: kevin
 * Date: 02/05/2018
 * Time: 19:47
 */

class LogOnOffToggleHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {

        if (!$container instanceof AbstractPluginManager) {

            //see https://docs.zendframework.com/zend-view/helpers/advanced-usage/
            $vcontainer = $container->get(HelperPluginManager::class);
        }


        return new LogOnOffToggleHelper(
            $container->get(AuthenticationService::class),
            $vcontainer->get('serverUrl'),
            $vcontainer->get('url')
        );
    }
}