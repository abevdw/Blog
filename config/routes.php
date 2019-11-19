<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\Authentication\AuthenticationMiddleware;
use Zend\Expressive\MiddlewareFactory;

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
 * @param Application $app
 * @param MiddlewareFactory $factory
 * @param ContainerInterface $container
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {

    $app->get('/blog2/public/', App\Handler\HomePageHandler::class, 'home');

    //  $app->route('/blog2/public/', [ AuthenticationMiddleware::class, App\Handler\HomePageHandler::class, ], ['GET'], 'home');

    $app->get('/blog2/public/api/ping', App\Handler\PingHandler::class, 'api.ping');

    $app->route('/blog2/public/edit', [ App\Handler\EditPageHandler::class, AuthenticationMiddleware::class, ], ['GET', 'POST'],'edit');

    $app->route('/blog2/public/login', [ App\Handler\LoginPageHandler::class, AuthenticationMiddleware::class, ], ['GET', 'POST'],'loginRenderer');

    //  NOTE(Chris Kruining) Login routes
    //  $app->get('/blog2/public/login', App\Handler\LoginPageHandler::class,  'loginRenderer');
    //  $app->post('/blog2/public/login', App\Handler\LoginPageHandler::class, 'loginHandler');
};
