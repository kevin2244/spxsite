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
use Zend\I18n\Validator\Alnum;
use Zend\Validator\ValidatorChain;

class ItemHandler implements RequestHandlerInterface
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
        $itemId = $request->getAttribute('itemid');

        $inputValidatorChain = new ValidatorChain();
        $inputValidatorChain->attach(new Alnum());

        if (!$inputValidatorChain->isValid($itemId)) {
            return new HtmlResponse(
                $this->renderer->render('error::404'),
                404
            );
        }

        try {
            $itemData = json_decode(
                $this->spxClient->request(
                    'GET',
                    "car-for-sale/id/$itemId"
                )->getBody()->getContents(),
                true
            );
        } catch (GuzzleException $e) {
            $itemData = [];
            error_log(
                'GuzzleException' . $e->getMessage(),
                E_USER_ERROR
            );
        }

        //redact contact information, e.g. phone number
        $itemData['contact_phone'] = 'REDACTED';


        try {
            $photoData = json_decode(
                $this->spxClient->request(
                    'GET',
                    "edit-car-photos/id/$itemId"
                )->getBody()->getContents(),
                true
            );
        } catch (GuzzleException $e) {
            $photoData = [];
            error_log(
                'GuzzleException' . $e->getMessage(),
                E_USER_ERROR
            );
        }

        $data = [];
        $data['itemid'] = $itemId;
        $data['itemdata'] = $itemData;
        $data['modelid'] = $itemId;
        $data['photos'] = $photoData;

        return new HtmlResponse($this->renderer->render(
            'app::item',
            $data
        ));
    }
}
