<?php
declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\LogOffHandler;
use Helmich\Psr7Assert\Psr7Assertions;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Expressive\Template\TemplateRendererInterface;


class LogOffHandlerTest extends TestCase
{
    use Psr7Assertions;

    public function testRedirect()
    {
        $authenticationServiceProphecy = $this->prophesize(AuthenticationService::class);
        $authenticationServiceProphecy->hasIdentity()->willReturn(true);
        $authenticationServiceProphecy->clearIdentity()->willReturn();

        $requestProphecy = $this->prophesize(ServerRequestInterface::class);

        $templateRendererProphecy = $this->prophesize(TemplateRendererInterface::class);

        $handler = new LogOffHandler(
            $authenticationServiceProphecy->reveal(),
            $templateRendererProphecy->reveal()
        );

        $this->assertResponseHasStatus($handler->handle($requestProphecy->reveal()), 302);
    }
}