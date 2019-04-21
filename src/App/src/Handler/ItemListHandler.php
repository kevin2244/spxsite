<?php

declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class ItemListHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    /** @var ClientInterface */
    private $spxClient;

    public function __construct(
        TemplateRendererInterface $renderer,
        ClientInterface $spxClient
    ) {
        $this->renderer = $renderer;
        $this->spxClient = $spxClient;
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
            error_log(
                'GuzzleException Found ' . $e->getMessage(),
                E_USER_ERROR
            );
        }

        $data['itemlist'] = $itemList;
        $data['page'] = $page;


        return new HtmlResponse($this->renderer->render(
            'app::item-list',
            $data
        ));
    }
}
