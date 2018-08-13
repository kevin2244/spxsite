<?php

declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp;
use GuzzleHttp\ClientInterface;
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

        //filter input
        $requestToken = $request->getAttribute('token');
        $sfilter = new I18n\Filter\Alnum();
        $token = $sfilter->filter($requestToken);

        //verify token
        try {
            $response = $this->spxClient->request('GET', "/verifyuser/$token");
        } catch (GuzzleHttp\Exception\ServerException $e) {

            if ($e instanceof GuzzleHttp\Exception || $e instanceof  \GuzzleHttp\Exception\ServerException || $e instanceof \GuzzleHttp\Exception\ConnectException) {
                // get the full text of the exception (including stack trace),
                // and replace the original message (possibly truncated),
                // with the full text of the entire response body.
                $message = str_replace(
                    rtrim($e->getMessage()),
                    (string) $e->getResponse()->getBody(),
                    (string) $e
                );

                // log your new custom guzzle error message
                error_log('Guzzle Exception: '.$message);
            }
            else {
                error_log('Exception: '.$e->getMessage().$e->getFile().$e->getLine());
            }
        }
        $verified = json_decode($response->getBody()->getContents(), true);

        $data = [];
        $data['verified'] = ($verified['verified'] === true) ? 'Verified' :
            'Verification Failure';

        return new HtmlResponse($this->renderer->render(
            'app::verify',
            $data
        ));
    }
}