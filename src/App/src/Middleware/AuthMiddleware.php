<?php
declare(strict_types=1);
/**
 * User: kevin
 * Date: 01/05/2018
 * Time: 23:09
 */

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\RedirectResponse;

class AuthMiddleware implements MiddlewareInterface
{
    private $auth;

    public function __construct(AuthenticationService $auth)
    {
        $this->auth = $auth;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if (! $this->auth->hasIdentity()) {
            return new RedirectResponse('/logon');
        }

        $identity = $this->auth->getIdentity();
        return $handler->handle($request->withAttribute(self::class, $identity));
    }
}