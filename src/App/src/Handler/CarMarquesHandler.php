<?php

declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;
use Zend\Filter\PregReplace;

class CarMarquesHandler implements RequestHandlerInterface
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
        $spxIpAddr = $this->hosts['SPX_IP_ADDR'];
        $client = new Client(['base_uri' => $spxIpAddr]);

        try {
            $response = $client->request('GET', "models/$marque");
        } catch (GuzzleException $e) {
            $noresponse = true;
        }

        $data = [];
        $data['marque'] = $marque;
        $data['modelresponse'] = empty($noresponse) ? $response->getBody() : '';

        return new HtmlResponse($this->template->render('app::car-marques', $data));
    }
}
