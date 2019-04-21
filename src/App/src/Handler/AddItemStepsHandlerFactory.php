<?php

declare(strict_types=1);

namespace App\Handler;

use App\Forms\AddItemStep1Form;
use App\Forms\AddItemStep2Form;
use App\Forms\AddItemStep3Form;
use App\Helpers\IdentHelper;
use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class AddItemStepsHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AddItemStepsHandler
    {
        return new AddItemStepsHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(AddItemStep1Form::class),
            $container->get(AddItemStep2Form::class),
            $container->get(AddItemStep3Form::class),
            $container->get(SPXGuzzleClientFactory::class),
            $container->get(IdentHelper::class)
        );
    }
}
