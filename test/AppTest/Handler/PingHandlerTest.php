<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\PingHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use  Helmich\Psr7Assert\Psr7Assertions;


class PingHandlerTest extends TestCase
{

    use Psr7Assertions;

    public function testResponse()
    {
        $pingHandler = new PingHandler();
        $response = $pingHandler->handle(
            $this->prophesize(ServerRequestInterface::class)->reveal()
        );

        $json = json_decode((string) $response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertTrue(isset($json->ack));
    }

    public function testResponse2()
    {
        $pingHandler = new PingHandler();
        $response = $pingHandler->handle(
            $this->prophesize(ServerRequestInterface::class)->reveal()
        );

        $this->assertResponseHasStatus($response, 200);

    }
}
