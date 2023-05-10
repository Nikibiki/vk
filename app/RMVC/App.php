<?php

namespace App\RMVC;

use App\Http\Request;
use App\RMVC\Route\Route;
use App\RMVC\Route\RouteDispatcher;
use App\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class App
{
    public static Request $request;
    public static Response $response;
    public static StorageInterface $storage;

    public static function run(): void
    {
        self::init();

        $routeMethod = 'getRoutes' . ucfirst(strtolower(self::$request->getMethod()));

        foreach(Route::$routeMethod() as $routeConfiguration) {
            $routeDispatcher = new RouteDispatcher($routeConfiguration);
            $routeDispatcher->process();
        }
    }

    private static function init(): void
    {
        self::$request = Request::createFromGlobals();
        if (self::$request->isJson()) {
            self::$response = new JsonResponse();
        } else {
            self::$response = new Response();
        }
    }
}