<?php

declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp\Client;
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
    private $hosts;

    public function __construct(
        Template\TemplateRendererInterface $template = null,
        $marquemap = [],
        $hosts     = []
    ) {
        $this->template  = $template;
        $this->marquemap = $marquemap;
        $this->hosts     = $hosts;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {

        $idfilter = new Alnum();
        $modelid  = $idfilter->filter($request->getAttribute('modelid'));

        $spxUrl = $this->hosts['SPX_URL'];
        $client = new Client(['base_uri' => $spxUrl]);
        $response = $client->request('GET', "model/modelid/$modelid");

        $data = [];
        $data['modelresponse'] = $response->getBody();
        $data['spx_ip_addr'] = $this->hosts['SPX_IP_ADDR'];
        $data['modelid'] = $modelid;

        return new HtmlResponse($this->template->render('app::car-model', $data));
    }
}
