<?php

declare(strict_types=1);

namespace App\Forms;

use Psr\Container\ContainerInterface;

class AddItemStep2FormFactory
{
    public function __invoke(ContainerInterface $container) : AddItemStep2Form
    {
        return new AddItemStep2Form();
    }
}
