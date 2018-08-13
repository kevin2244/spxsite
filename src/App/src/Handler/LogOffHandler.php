<?php
declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Diactoros\Response;
use Zend\Expressive\Template\TemplateRendererInterface;



class LogOffHandler implements RequestHandlerInterface
{

    private $authenticationService;
    private $renderer;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        TemplateRendererInterface $renderer
    ) {
        $this->authenticationService = $authenticationService;
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        //check status
        if (!$this->authenticationService->hasIdentity()) {
            $data['status'] = 'You are logged off';
            return new Response\HtmlResponse($this->renderer->render('app::logoff', $data));
        }

        //Clear Ident
        $this->authenticationService->clearIdentity();

        return new Response\RedirectResponse('/logon');
    }
}