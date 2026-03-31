<?php

namespace Adeel3330\InsightGuard\Services;

use Illuminate\Support\Facades\Route;
use ReflectionClass;

class SecurityScanner
{
    public function scanControllers()
    {
        $issues = [];

        $controllers = $this->getAllControllers();

        foreach ($controllers as $controllerClass) {
            $reflection = new ReflectionClass($controllerClass);

            foreach ($reflection->getMethods() as $method) {
                $route = $this->findRouteForMethod($controllerClass, $method->name);

                // Check for auth middleware
                if ($route && !in_array('auth', $route->middleware())) {
                    $issues[] = "{$controllerClass}@{$method->name} is missing auth middleware";
                }

                // Check for validation (simplified: look for calls to $this->validate)
                if (strpos($method->getBodyAsString(), '$this->validate') === false) {
                    $issues[] = "{$controllerClass}@{$method->name} may be missing validation";
                }
            }
        }

        return $issues;
    }

    private function getAllControllers()
    {
        // Scan app/Http/Controllers folder
        $controllerPath = app_path('Http/Controllers');
        $files = glob($controllerPath.'/*.php');

        $controllers = [];
        foreach ($files as $file) {
            $class = 'App\\Http\\Controllers\\'.basename($file, '.php');
            if (class_exists($class)) {
                $controllers[] = $class;
            }
        }

        return $controllers;
    }

    private function findRouteForMethod($controller, $method)
    {
        foreach (Route::getRoutes() as $route) {
            if ($route->getActionName() === $controller.'@'.$method) {
                return $route;
            }
        }

        return null;
    }
}