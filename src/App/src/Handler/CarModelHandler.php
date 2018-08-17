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

        try {
            $modelData = json_decode($this->spxClient->request('GET', "model/modelid/$modelid")->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            $modelData = [];
            error_log('GuzzleException' . $e->getMessage(),
                E_USER_ERROR);
        }

        $data = [];
        $data['modeldata'] = $modelData;
        $data['modelid'] = $modelid;
        $data['marquemap'] = $this->marquemap;

        return new HtmlResponse($this->template->render('app::car-model', $data));
    }
}
