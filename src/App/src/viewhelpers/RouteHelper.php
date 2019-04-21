<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\viewhelpers;

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
        $this->routeResult = $routeResult;
    }
}
