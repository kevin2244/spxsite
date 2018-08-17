<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\AboutHandler;
use Helmich\Psr7Assert\Psr7Assertions;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


class AboutHandlerTest extends TestCase
{
    use Psr7Assertions;

    public function testResponse()
    {
        $proph = $this->prophesize(TemplateRendererInterface::class);
        $proph->render('app::about')->willReturn('sometext');

        $templateRenderer = $proph->reveal();

        $handler = new AboutHandler($templateRenderer);
        $prophecy = $this->prophesize(ServerRequestInterface::class)->reveal();
        $this->assertResponseHasStatus($handler->handle($prophecy), 200);
    }
}