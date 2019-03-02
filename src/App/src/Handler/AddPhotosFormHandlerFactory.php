<?php

declare(strict_types=1);

namespace App\Handler;

use App\Forms\AddPhotosForm;
use Psr\Container\ContainerInterface;

class AddPhotosFormHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AddPhotosFormHandler
    {
        return new AddPhotosFormHandler(
            $container->get(AddPhotosForm::class)
        );
    }
}
