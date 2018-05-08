<?php

declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp;
use function json_decode;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;
use Zend\I18n\Filter\Alnum;

class CarModelHandler implements RequestHandlerInterface
{
    private $template;
    private $marquemap;
    private $spxClient;

    public function __construct(
        Template\TemplateRendererInterface $template = null,
        $marquemap = [],
        GuzzleHttp\ClientInterface $spxClient
    ) {
        $this->template  = $template;
        $this->marquemap = $marquemap;
        $this->spxClient = $spxClient;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {

        $idfilter = new Alnum();
        $modelid  = $idfilter->filter($request->getAttribute('modelid'));
        $response = $this->spxClient->request('GET', "model/modelid/$modelid");

        $data = [];

        $data['modeldata'] = json_decode($response->getBody()->getContents(), true);

        $data['modelid'] = $modelid;

        $data['marquemap'] = $this->marquemap;


        return new HtmlResponse($this->template->render('app::car-model', $data));
    }
}
