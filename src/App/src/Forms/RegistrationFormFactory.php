<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\Forms;


use Psr\Container\ContainerInterface;

class RegistrationFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RegistrationForm();
    }
}