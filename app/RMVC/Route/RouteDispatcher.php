<?php

namespace App\RMVC\Route;

use App\RMVC\App;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Response;

class RouteDispatcher
{
    private string $requestUri = '/';
    private array $paramMap = [];
    private array $paramRequestMap = [];

    private RouteConfiguration $routeConfiguration;

    /**
     * @param RouteConfiguration $routeConfiguration
     */
    public function __construct(RouteConfiguration $routeConfiguration)
    {
        $this->routeConfiguration = $routeConfiguration;
    }

    public function process(): void
    {
        $this->saveRequest();
        $this->setParamMap();
        $this->makeRegexRequest();
        $this->run();
    }

    private function saveRequest(): void
    {
        $this->requestUri = preg_replace('/\?.*$/', '', $_SERVER['REQUEST_URI']);
        if ($this->requestUri != '/') {
            $this->requestUri = trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     * @return void
     */
    private function setParamMap(): void
    {
        $routeArray = explode('/', $this->routeConfiguration->route);
        foreach ($routeArray as $paramPosition => $param) {
            if (preg_match('/{.*}/', $param)) {
                $this->paramMap[$paramPosition] = trim($param, '{}');
            }
        }
    }

    private function makeRegexRequest(): void
    {
        $requestUriArray = $this->requestUri === '/' ? [] : explode('/', $this->requestUri);

        foreach ($this->paramMap as $paramPosition => $param) {
            if (!isset($requestUriArray[$paramPosition])) break;

            $this->paramRequestMap[$param] = $requestUriArray[$paramPosition];
            $requestUriArray[$paramPosition] = '{.*}';

        }
        $this->requestUri = count($requestUriArray) == 0 ? '^\/$' : '^' . implode('\/', $requestUriArray) . '$';
    }

    private function run(): void
    {
        if (preg_match("/$this->requestUri/", $this->routeConfiguration->route)) {
            $this->handle()->send();
            die();
        }
    }

    private function handle(): Response
    {
        $className = $this->routeConfiguration->controller;
        $action = $this->routeConfiguration->action;
        return (new $className())->$action(...$this->paramRequestMap);
    }
}