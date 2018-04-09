<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class HirePurchaseHPFactory
{
    public function __invoke(ContainerInterface $container) : HirePurchaseHP
    {
        return new HirePurchaseHP($container->get(TemplateRendererInterface::class));
    }
}
