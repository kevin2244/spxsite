<?php

namespace App\Middleware;

use App\viewhelpers\RouteHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouteResult;


/**
 * User: kevin
 * Date: 27/04/2018
 * Time: 02:34
 */

class RouteHelperMiddleware implements MiddlewareInterface
{

    private $routeHelper;

    public function __construct(RouteHelper $routeHelper)
    {
        $this->routeHelper = $routeHelper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $result = $request->getAttribute(RouteResult::class);

        if ($result instanceof RouteResult) {
            $this->routeHelper->setRouteResult($result);
        }

        return $handler->handle($request);
    }
}