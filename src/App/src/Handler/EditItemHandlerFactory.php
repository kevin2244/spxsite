<?php

declare(strict_types=1);

namespace App\Handler;

use App\Forms\AddPhotosForm;
use App\Forms\EditItemForm;
use App\Helpers\IdentHelper;
use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

class EditItemHandlerFactory
{
    public function __invoke(ContainerInterface $container) : EditItemHandler
    {
        return new EditItemHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(SPXGuzzleClientFactory::class),
            $container->get(AddPhotosForm::class),
            $container->get(UrlHelper::class),
            $container->get(IdentHelper::class),
            $container->get(EditItemForm::class),
            $container->get('config')
        );
    }
}
