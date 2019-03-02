<?php
/**
 * @copyright Kevin Smith 2019
 * Date: 01/01/2019
 * Time: 16:42
 */
declare(strict_types = 1);

namespace App\Forms;

use Psr\Container\ContainerInterface;

class AddPhotosFormFactory
{
    public function __invoke(ContainerInterface $container) : AddPhotosForm
    {
        return new AddPhotosForm();
    }
}