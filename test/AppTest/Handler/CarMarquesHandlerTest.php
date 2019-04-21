<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\CarMarquesHandler;
use Helmich\Psr7Assert\Psr7Assertions;
use PHPUnit\Framework\TestCase;
use Zend\Expressive\Template\TemplateRendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class CarMarquesHandlerTest extends TestCase
{
    use Psr7Assertions;

    public function testResponse()
    {
        //Test Data
        $marquemap = ['somemarque' => 'SomeMarque'];
        $requestedMarque = 'somemarque';
        $data               = [];
        $data['marque']     = $marquemap[$requestedMarque];
        $data['marquedata'] = ["somekey" => "someval"];
        $data['spxclienterror'] = false;

        //API prophecy
        $apiprophecy = $this->prophesize(\GuzzleHttp\ClientInterface::class);
        $apiResponse = new \GuzzleHttp\Psr7\Response(
            200, [], '{"somekey":"someval"}'
        );
        $apiprophecy->request("GET", "models/{$marquemap[$requestedMarque]}")->willReturn($apiResponse);

        //Template Rendering Prophecy
        $templateRenderer = $this->prophesize(TemplateRendererInterface::class);
        $templateRenderer->render('app::car-marques', $data)->willReturn(
            'sometext'
        );

        //Request prophecy
        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getAttribute('marque')->willReturn($requestedMarque);

        $handler = new CarMarquesHandler(
            $apiprophecy->reveal(), $templateRenderer->reveal(), $marquemap
        );

        $this->assertResponseHasStatus($handler->handle($request->reveal()), 200);
    }

    public function testMarqueNotFoundResponseGives404()
    {
        //Test Data
        $marquemap = ['somemarque' => 'SomeMarque'];
        $requestedMarque = 'someOTHERmarque';

        //API prophecy
        $apiprophecy = $this->prophesize(\GuzzleHttp\ClientInterface::class);

        //Template Rendering Prophecy
        $templateRenderer = $this->prophesize(TemplateRendererInterface::class);
        $templateRenderer->render('error::404')->willReturn('Some 404 text');

        //Request prophecy
        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getAttribute('marque')->willReturn($requestedMarque);

        $handler = new CarMarquesHandler(
            $apiprophecy->reveal(), $templateRenderer->reveal(), $marquemap
        );

        $this->assertResponseHasStatus($handler->handle($request->reveal()), 404);
    }
}
