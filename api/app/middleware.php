<?php
declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);

    // $app->add(new Tuupola\Middleware\CorsMiddleware([
    //     "origin" => ["*"],
    //     "methods" => ["GET", "POST", "PATCH", "DELETE", "OPTIONS"],    
    //     "headers.allow" => ["Origin", "Content-Type", "Authorization", "Accept", "ignoreLoadingBar", "X-Requested-With", "Access-Control-Allow-Origin"],
    //     "headers.expose" => [],
    //     "credentials" => true,
    //     "cache" => 0,        
    // ]));

    // $app->add(function ($req, $res, $next) {
    //     $response = $next($req, $res);
    //     return $response
    //             ->withHeader('Access-Control-Allow-Origin', '')
    //             ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    //             ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    // });
};
