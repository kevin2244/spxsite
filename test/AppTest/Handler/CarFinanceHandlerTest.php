<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\CarFinanceHandler;
use Helmich\Psr7Assert\Psr7Assertions;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CarFinanceHandlerTest extends TestCase
{
    use Psr7Assertions;

    public function testResponse()
    {
        $templateRenderer = $this->prophesize(TemplateRendererInterface::class);
        $templateRenderer->render('app::car-finance',[])->willReturn('sometext');

        $handler = new CarFinanceHandler($templateRenderer->reveal());

        $prophecy = $this->prophesize(ServerRequestInterface::class)->reveal();
        $this->assertResponseHasStatus($handler->handle($prophecy), 200);
    }
}