<?php

declare(strict_types=1);

namespace App\Forms;

use Psr\Container\ContainerInterface;

class AddItemFormFactory
{
    public function __invoke(ContainerInterface $container) : AddItemForm
    {
        return new AddItemForm();
    }
}
