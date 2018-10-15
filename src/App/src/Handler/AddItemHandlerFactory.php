<?php

declare(strict_types=1);

namespace App\Handler;

use App\Forms\AddItemForm;
use App\Helpers\IdentHelper;
use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class AddItemHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AddItemHandler
    {
        return new AddItemHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(AddItemForm::class),
            $container->get(SPXGuzzleClientFactory::class),
            $container->get(IdentHelper::class)
        );
    }
}
