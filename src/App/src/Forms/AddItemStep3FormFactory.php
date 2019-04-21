<?php

declare(strict_types=1);

namespace App\Forms;

use Psr\Container\ContainerInterface;

class AddItemStep3FormFactory
{
    public function __invoke(ContainerInterface $container) : AddItemStep3Form
    {
        return new AddItemStep3Form();
    }
}
