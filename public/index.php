<?php

declare(strict_types=1);

// Delegate static file requests back to the PHP built-in webserver
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
(function () {

    $container = require 'config/container.php';

    $app = $container->get(Application::class);
    $factory = $container->get(MiddlewareFactory::class);

    // Execute programmatic/declarative middleware pipeline and routing
    // configuration statements
    (require 'config/pipeline.php')($app, $factory, $container);
    (require 'config/routes.php')($app, $factory, $container);

    //  $container->get(Zend\Stratigility\Middleware\ErrorHandler::class)->attachListener(function ($e, $req, $res){
    //  var_dump($e->getMessage(), $req, $res);
    //  });

    $app->run();
})();
