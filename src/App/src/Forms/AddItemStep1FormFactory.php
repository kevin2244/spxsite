<?php

declare(strict_types=1);

namespace App\Forms;

use Psr\Container\ContainerInterface;

class AddItemStep1FormFactory
{
    public function __invoke(ContainerInterface $container) : AddItemStep1Form
    {
        return new AddItemStep1Form();
    }
}
