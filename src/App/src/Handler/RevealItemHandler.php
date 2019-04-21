<?php

declare(strict_types=1);

namespace App\Handler;

use App\Helpers\IdentHelper;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\I18n\Validator\Alnum;
use Zend\Validator\ValidatorChain;
use function error_log;

class RevealItemHandler implements RequestHandlerInterface
{

    /** @var ClientInterface */
    private $spxClient;

    /** @var IdentHelper */
    private $identHelper;

    public function __construct(
        ClientInterface $spxClient,
        IdentHelper $identHelper
    ) {
        $this->spxClient = $spxClient;
        $this->identHelper = $identHelper;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $ih = $this->identHelper;

        if ($ih() === null) {
            return new JsonResponse([], 204);
        }

        $itemId = $request->getAttribute('itemid');

        $inputValidatorChain = new ValidatorChain();
        $inputValidatorChain->attach(new Alnum());

        if (!$inputValidatorChain->isValid($itemId)) {
            return new JsonResponse([], 404);
        }

        try {
            $itemData = json_decode(
                $this->spxClient->request('GET', "car-for-sale/id/$itemId")->getBody()->getContents(),
                true
            );
        } catch (GuzzleException $e) {
            $itemData = [];
            error_log(
                'GuzzleException' . $e->getMessage(),
                E_USER_ERROR
            );
        }
        if (!empty($itemData)) {
            return new JsonResponse($itemData, 200);
        } else {
            return new JsonResponse($itemData, 404);
        }
    }
}
