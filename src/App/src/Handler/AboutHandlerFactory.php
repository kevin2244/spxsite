<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 07/04/2018
 * Time: 17:51
 */

declare(strict_types = 1);

namespace App\Handler;
error_log('In AH Factory...');

use function error_log;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class AboutHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {


        $template = $container->get(TemplateRendererInterface::class);
        error_log('In AH Factory...');
        return new AboutHandler($template);
    }
}