<?php

declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;
use Zend\Validator\Regex;
use Zend\Validator\ValidatorChain;

class CarMarquesHandler implements RequestHandlerInterface
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
        $marquerq = $request->getAttribute('marque');

        $inputValidatorChain = new ValidatorChain();
        $inputValidatorChain->attach(new Regex(['pattern' => '/^[[:alnum:]-]+$/u']));

        if (!$inputValidatorChain->isValid($marquerq)) {
            return new HtmlResponse($this->template->render('error::404'), 404);
        }

        $marquemap = $this->marquemap;

        if (!empty($marquemap[$marquerq])) {
            $marque = $marquemap[$marquerq];
        }
        else {
            return new HtmlResponse($this->template->render('error::404'), 404);
        }

        try {
            $response = $this->spxClient->request('GET', "models/$marque");
        } catch (GuzzleException $e) {
            //TODO Log Error
        }

        $data               = [];
        $data['marque']     = $marque;
        $data['marquedata'] = json_decode($response->getBody()->getContents(), true);

        return new HtmlResponse($this->template->render('app::car-marques', $data));
    }
}
