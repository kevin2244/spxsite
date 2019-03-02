<?php

declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use function error_log;

class RemoveItemHandler implements RequestHandlerInterface
{

    /** @var ClientInterface */
    private $spxClient;

    public function __construct( ClientInterface $clientInterface)
    {
        $this->spxClient = $clientInterface;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $itemId = $request->getAttribute('itemid');

        $data = false;
        $status = 500;

        try {
            $response = $this->spxClient->request(
                'DELETE',
                "car-for-sale/id/$itemId"
            );
            $status = $response->getStatusCode();
            $data = json_decode($response->getBody()->getContents());
        } catch (GuzzleException $e) {

            if ($e instanceof GuzzleHttp\Exception\RequestException) {

                // replace the original message (possibly truncated),
                // with the full text of the response body.
                if (!empty($e->getResponse())) {
                    $message = str_replace(
                        rtrim($e->getMessage()),
                        (string)$e->getResponse()->getBody(),
                        (string)$e
                    );
                } else {
                    $message = $e->getMessage()
                                            . $e->getFile()
                        . $e->getLine();
                }
                error_log('Guzzle RequestException: ' .
                    $message, E_USER_ERROR);
            } else {
                error_log('GuzzleException: '
                    . $e->getMessage()
                    . $e->getFile()
                    . $e->getLine(), E_USER_ERROR);
            }
        }
        return new JsonResponse($data, $status);
    }
}