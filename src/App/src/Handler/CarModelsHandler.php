<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Escaper\Escaper;
use Zend\Expressive\Template;
use Zend\Validator\Regex;
use Zend\Validator\ValidatorChain;

class CarModelsHandler implements RequestHandlerInterface
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
        $inputMarqueValidatorChain = new ValidatorChain();
        $inputMarqueValidatorChain->attach(
            new Regex(['pattern' => '/^[[:alnum:]-]+$/u'])
        );

        if (!$inputMarqueValidatorChain->isValid($marquerq)) {
            return new HtmlResponse($this->template->render('error::404'), 404);
        }

        $marqueNameMap = array_flip($this->marquemap);

        if (!empty($marqueNameMap[$marquerq])) {

            $marqueKeyName = $marqueNameMap[$marquerq];
            $marqueName = $marquerq;
        } else {

            return new HtmlResponse($this->template->render('error::404'), 404);
        }

        $modelrq = $request->getAttribute('model');

        //TODO - need defined rules for model name,
        //in this application and/or the SPXAPI
        //Allow non alnum characters such as exclamation marks e.g. VW Up!
        //or Cee'd
        $runModelValidation = false;
        if ($runModelValidation) {

            $inputModelValidatorChain = new ValidatorChain();
            $inputModelValidatorChain->attach(
                new Regex(['pattern' => '/^[[:alnum:]-]+$/u'])
            );
            if (!$inputModelValidatorChain->isValid($modelrq)) {

                return new HtmlResponse($this->template->render('error::404'), 404);
            }
        }

        $modelrq = $request->getAttribute('model');
        $model = $modelrq;

        //Since we currently do not check if user submitted Model param exists
        //as an entity,
        //and do not necessarily filter it,
        //escape it for output
        $escaper    = new Escaper();
        $modelUrl   = $escaper->escapeUrl($model);
        $modelHtml  = $escaper->escapeHtml($model);

        $data = [];

        try {
            $cardata = json_decode($this->spxClient->request('GET', "marque/$marqueKeyName/model/$model")->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            error_log('GuzzleException' . $e->getMessage(),
                E_USER_ERROR);
            $cardata = [];
        }

        $data['cardata']        = $cardata;
        $data['marquekeyname']  = $marqueKeyName;
        $data['marquename']     = $marqueName;
        $data['model']          = $model;
        $data['modelhtml']      = $modelHtml;
        $data['modelurl']       = $modelUrl;

        return new HtmlResponse($this->template->render('app::car-models', $data));
    }
}
