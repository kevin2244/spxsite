<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Handler;

use App\Auth\AuthAdapter;
use App\Forms\LogonForm;
use Psr\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Expressive\Template\TemplateRendererInterface;

class LogonHandlerFactory
{
    public function __invoke(ContainerInterface $container) : LogonHandler
    {
        return new LogonHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(AuthenticationService::class),
            $container->get(AuthAdapter::class),
            $container->get(LogonForm::class)
        );
    }
}
