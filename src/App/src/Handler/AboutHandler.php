<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Handler;

use App\Middleware\AuthMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class AboutHandler implements RequestHandlerInterface
{
    private $template;

    public function __construct(
        TemplateRendererInterface $template = null
    ) {
        $this->template = $template;
    }


    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data['ident'] = $request->getAttribute(AuthMiddleware::class);
        return new HtmlResponse($this->template->render('app::about'));
    }
}
