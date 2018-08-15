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
use Zend\I18n;

class VerifyHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
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

        $data = [];
        $verified = [];
        $data['verified'] = 'Verification Failure';

        //filter input
        $requestToken = $request->getAttribute('token');
        $sfilter = new I18n\Filter\Alnum();
        $token = $sfilter->filter($requestToken);


        //verify token
        try {
            $response = $this->spxClient->request('GET', "/verifyuser/$token");
            $verified = json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {

            error_log('GuzzleException' . $e->getMessage(),
                E_USER_ERROR);
        }

        if (array_key_exists('verified', $verified)) {
            if  ($verified['verified'] === true) {
                $data['verified'] = 'Verified';
            }
        }

        return new HtmlResponse($this->renderer->render(
            'app::verify',
            $data
        ));
    }
}