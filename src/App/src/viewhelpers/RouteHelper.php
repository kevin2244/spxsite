<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 26/04/2018
 * Time: 04:27
 */

namespace App\viewhelpers;

use function error_log;
use Zend\Expressive\Router\RouteResult;

class RouteHelper
{

    private $routeResult;

    public function __invoke()
    {
        return $this->routeResult;
    }

    public function setRouteResult(RouteResult $routeResult)
    {
        error_log('Setting Route Result...');
        $this->routeResult = $routeResult;
    }
}