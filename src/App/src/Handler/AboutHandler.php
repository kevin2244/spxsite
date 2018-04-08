<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 07/04/2018
 * Time: 17:29
 */

declare(strict_types=1);

namespace App\Handler;

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
        return new HtmlResponse($this->template->render('app::about'));
    }
}