<?php

declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;
use Zend\Filter\PregReplace;

class CarModelsHandler implements RequestHandlerInterface
{
    private $template;
    private $marquemap;
    private $hosts;

    public function __construct(
        Template\TemplateRendererInterface $template = null,
        $marquemap = [],
        $hosts = []
    ) {
        $this->template  = $template;
        $this->marquemap = $marquemap;
        $this->hosts = $hosts;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $filter = new PregReplace(['pattern' => '/[^[:alnum:]-]/u']);
        $marquerq = $filter->filter($request->getAttribute('marque'));
        $marquemap = $this->marquemap;
        $marque = (!empty($marquemap[$marquerq])) ? $marquemap[$marquerq] :
            ucfirst($marquerq);

        $modelrq = $request->getAttribute('model');
        $model = $filter->filter($modelrq);

        $spxUrl = $this->hosts['SPX_URL'];
        $client = new Client(['base_uri' => $spxUrl]);
        $response = $client->request('GET', "marque/$marque/model/$model");

        $data = [];
        $data['marque'] = $marque;
        $data['model'] = $model;
        $data['modelresponse'] = $response->getBody();

        return new HtmlResponse($this->template->render('app::car-models', $data));
    }
}
