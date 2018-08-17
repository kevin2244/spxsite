<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Handler;

use App\Forms\SearchForm;
use App\Model\SPXGuzzleClientFactory;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class SearchFactory
{
    public function __invoke(ContainerInterface $container) : Search
    {
        return new Search(
            $container->get(TemplateRendererInterface::class),
            $container->get(SearchForm::class),
            $container->get(SPXGuzzleClientFactory::class)
        );
    }
}
