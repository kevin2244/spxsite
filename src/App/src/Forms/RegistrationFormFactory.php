<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17/05/2018
 * Time: 21:01
 */

namespace App\Forms;


use Psr\Container\ContainerInterface;

class RegistrationFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RegistrationForm();
    }
}