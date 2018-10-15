<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
use Zend\Expressive\Session\SessionMiddleware;


/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/', [ App\Handler\HomePageHandler::class], 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');
    $app->get('/about', [App\Handler\AboutHandler::class], 'about');
    $app->get('/car-finance', App\Handler\CarFinanceHandler::class, 'car-finance');
    $app->get('/hire-purchase-hp', App\Handler\HirePurchaseHP::class, 'hire-purchase-hp');
    $app->get(
        '/scrappage-schemes-explained',
        App\Handler\ScrappageSchemesExplainedHandler::class,
        'scrappage-schemes-explained'
    );
    $app->get('/marque/{marque:.*}/model/{model:.*}/id/{modelid:.*}', App\Handler\CarModelHandler::class, 'carmodel');
    $app->get('/marque/{marque:.*}/model/{model:.*}', App\Handler\CarModelsHandler::class, 'carmodels');
    $app->get('/marque/{marque:.*}', App\Handler\CarMarquesHandler::class, 'carmarques');
    $app->post('/search', App\Handler\Search::class, 'search');
    $app->get('/search', App\Handler\Search::class, 'search-post');
    $app->get('/logon', App\Handler\LogonHandler::class, 'log-on');
    $app->post('/logon', App\Handler\LogonHandler::class, 'log-on-post');
    $app->get('/logoff', App\Handler\LogOffHandler::class, 'log-off');
    $app->get('/register', App\Handler\RegistrationHandler::class, 'registration');
    $app->post('/register', App\Handler\RegistrationHandler::class, 'registration-post');
    $app->get('/verify/{token:.*}', App\Handler\VerifyHandler::class, 'verify');

    $app->get('/addcar', [
        SessionMiddleware::class,
        App\Handler\AddItemHandler::class
        ],
        'additem'
    );

    $app->post('/addcar', [
        SessionMiddleware::class,
        App\Handler\AddItemHandler::class
        ],
        'additem-post');

    $app->get('/item/{itemid:.*}', App\Handler\ItemHandler::class, 'item');
    $app->get('/itemlist', App\Handler\ItemListHandler::class, 'itemlist');
};
