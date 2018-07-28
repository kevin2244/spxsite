<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Forms\RegistrationForm;
use App\Model\SPXGuzzleClientFactory;
use Zend\Expressive\Helper\ServerUrlHelper;
use Zend\Expressive\Helper\UrlHelper;

class RegistrationHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RegistrationHandler
    {
        return new RegistrationHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(RegistrationForm::class),
            $container->get(SPXGuzzleClientFactory::class),
            $container->get(ServerUrlHelper::class),
            $container->get(UrlHelper::class),
            $container->get('config')['mailgun']
        );
    }
}
