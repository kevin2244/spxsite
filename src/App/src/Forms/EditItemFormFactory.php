<?php

declare(strict_types=1);

namespace App\Forms;

use Psr\Container\ContainerInterface;

class EditItemFormFactory
{
    public function __invoke(ContainerInterface $container) : EditItemForm
    {
        return new EditItemForm();
    }
}
