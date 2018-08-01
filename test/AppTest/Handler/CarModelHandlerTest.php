<?php
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\CarModelHandler;
use Helmich\Psr7Assert\Psr7Assertions;
use PHPUnit\Framework\TestCase;
use Zend\Expressive\Template\TemplateRendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class CarModelHandlerTest extends TestCase
{
    use Psr7Assertions;

    public function testResponse()
    {
        //Test Data
        $marquemap = ['somemarque' => 'SomeMarque'];
        $requestedModelId = 'modelidstring';
        $data = [];
        $data['marquemap'] = $marquemap;
        $data['modeldata'] = ["somekey" => "someval"];
        $data['modelid'] = $requestedModelId;

        //API prophecy
        $apiprophecy = $this->prophesize(\GuzzleHttp\ClientInterface::class);
        $apiResponse = new \GuzzleHttp\Psr7\Response(
            200, [], '{"somekey":"someval"}'
        );
        $apiprophecy->request("GET", "model/modelid/$requestedModelId")
            ->willReturn($apiResponse);

        //Template Rendering Prophecy
        $templateRenderer = $this->prophesize(TemplateRendererInterface::class);
        $templateRenderer->render('app::car-model', $data)->willReturn(
            'sometext'
        );

        //Request prophecy
        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getAttribute('modelid')->willReturn($requestedModelId);

        $handler = new CarModelHandler(
            $templateRenderer->reveal(), $marquemap, $apiprophecy->reveal()
        );

        $this->assertResponseHasStatus(
            $handler->handle($request->reveal()), 200
        );
    }
}
