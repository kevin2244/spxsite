<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App;

use App\Handler\AddItemStepsHandlerFactory;
use App\Handler\ItemHandlerFactory;
use App\Handler\ItemListHandlerFactory;
use App\Handler\RemoveItemHandlerFactory;
use Zend\Authentication\AuthenticationService;

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
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
                Model\MarqueList::class => Model\MarqueList::class,
                Forms\LogonForm::class => Forms\LogonForm::class,
                Library\Csprng::class => Library\Csprng::class
            ],
            'factories'  => [

                Handler\HomePageHandler::class   => Handler\HomePageHandlerFactory::class,
                Handler\CarMarquesHandler::class => Handler\CarMarquesHandlerFactory::class,
                Handler\CarModelHandler::class => Handler\CarModelHandlerFactory::class,
                Handler\CarModelsHandler::class  => Handler\CarModelsHandlerFactory::class,
                Handler\AboutHandler::class => Handler\AboutHandlerFactory::class,
                Handler\CarFinanceHandler::class => Handler\CarFinanceHandlerFactory::class,
                Handler\ScrappageSchemesExplainedHandler::class =>
                    Handler\ScrappageSchemesExplainedHandlerFactory::class,
                Handler\RegistrationHandler::class => Handler\RegistrationHandlerFactory::class,
                Handler\EditItemHandler::class => Handler\EditItemHandlerFactory::class,
                Handler\MyItemListHandler::class => Handler\MyItemListHandlerFactory::class,
                Handler\RemovePhotoHandler::class => Handler\RemovePhotoHandlerFactory::class,
                Forms\SearchForm::class => Forms\SearchFormFactory::class,
                Forms\RegistrationForm::class => Forms\RegistrationFormFactory::class,
                Forms\AddItemForm::class => Forms\AddItemFormFactory::class,
                Forms\EditItemForm::class => Forms\EditItemFormFactory::class,
                Forms\AddPhotosForm::class => Forms\AddPhotosFormFactory::class,
                Forms\AddItemStep1Form::class => Forms\AddItemStep1FormFactory::class,
                Forms\AddItemStep2Form::class => Forms\AddItemStep2FormFactory::class,
                Forms\AddItemStep3Form::class => Forms\AddItemStep3FormFactory::class,
                Model\SPXGuzzleClientFactory::class => Model\SPXGuzzleClientFactory::class,
                Auth\AuthAdapter::class => Auth\AuthAdapterFactory::class,
                AuthenticationService::class => Auth\AuthenticationServiceFactory::class,
                Middleware\AuthMiddleware::class => Middleware\AuthMiddlewareFactory::class,
                Handler\LogOffHandler::class => Handler\LogOffHandlerFactory::class,
                Helpers\IdentHelper::class => Helpers\IdentHelperFactory::class,
                Handler\ItemListHandler::class => ItemListHandlerFactory::class,
                Handler\ItemHandler::class => ItemHandlerFactory::class,
                Handler\RemoveItemHandler::class => RemoveItemHandlerFactory::class,
                Handler\AddItemStepsHandler::class => AddItemStepsHandlerFactory::class
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
