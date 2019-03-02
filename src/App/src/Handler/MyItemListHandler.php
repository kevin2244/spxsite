<?php

declare(strict_types=1);

namespace App\Handler;


use App\Helpers\IdentHelper;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class MyItemListHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    /** @var ClientInterface */
    private $spxClient;

    /** @var IdentHelper */
    private $identHelper;

    public function __construct(
        TemplateRendererInterface $renderer,
        ClientInterface $spxClient,
        IdentHelper $identHelper
    ) {
        $this->renderer = $renderer;
        $this->spxClient = $spxClient;
        $this->identHelper = $identHelper;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {

        $uriQueryOptions = [];

        $qp = $request->getQueryParams();

        $page = $qp['page'] ?? '1';

        if (!empty($qp)) {
            $uriQueryOptions['query']['page'] = $page;
        }

        //add seller ID to query options...
        $ih = $this->identHelper;
        $uriQueryOptions['query']['sellerid'] = $ih()['_id']['$oid'];

        try {
            $itemList = json_decode(
                $this->spxClient->request(
                    'GET',
                    "cars-for-sale",
                    $uriQueryOptions
                )->getBody()->getContents(),
                true
            );
        } catch (GuzzleException $e) {
            $itemList = [];

            if (!empty($e->getResponse())) {
                $message = str_replace(
                    rtrim($e->getMessage()),
                    (string)$e->getResponse()->getBody(),
                    (string)$e
                );
            } else {
                $message = $e->getMessage();
            }


            error_log(
                'GuzzleException' . $message,
                E_USER_ERROR
            );
        }

        $data['itemlist'] = $itemList;
        $data['page'] = $page;


        return new HtmlResponse($this->renderer->render(
            'app::my-item-list',
            $data
        ));
    }
}
