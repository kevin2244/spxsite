<?php

declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use function error_log;

class RemovePhotoHandler implements RequestHandlerInterface
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
        $photoId = $request->getAttribute('photoid');
        $data = [];
        $status = 500;

        try {
            $response = $this->spxClient->request(
                'DELETE',
                "car-photo/itemid/$itemId/photoid/$photoId"
            );
            $status = $response->getStatusCode();
            $data = json_decode($response->getBody()->getContents(),
                true
            );
        } catch (GuzzleException $e) {
            error_log(
                'GuzzleException' . $e->getMessage(),
                E_USER_ERROR
            );
        }

        return new JsonResponse($data, $status);
    }
}