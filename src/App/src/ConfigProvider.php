<?php

declare(strict_types=1);

namespace App;
use function error_log;


error_log('In Config Provider...');

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        error_log('Returning Dependencies');
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,

            ],
            'factories'  => [

                Handler\HomePageHandler::class   => Handler\HomePageHandlerFactory::class,
                Handler\CarMarquesHandler::class => Handler\CarMarquesHandlerFactory::class,
                Handler\CarModelHandler::class => Handler\CarModelHandlerFactory::class,
                Handler\CarModelsHandler::class  => Handler\CarModelsHandlerFactory::class,
                Handler\AboutHandler::class => Handler\AboutHandlerFactory::class,
                Handler\CarFinanceHandler::class => Handler\CarFinanceHandlerFactory::class,
                Handler\ScrappageSchemesExplainedHandler::class => Handler\ScrappageSchemesExplainedHandlerFactory::class,
                Forms\SearchForm::class => Forms\SearchFormFactory::class,
                Model\SPXGuzzleClientFactory::class => Model\SPXGuzzleClientFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
