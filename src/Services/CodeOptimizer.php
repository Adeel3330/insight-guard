<?php

namespace Adeel3330\InsightGuard\Services;

use Illuminate\Support\Facades\Route;

class CodeOptimizer
{
    protected array $issues = [];

    /**
     * Detect unoptimized routes or middleware
     */
    public function analyzeRoutes(): array
    {
        $routes = Route::getRoutes();
        foreach ($routes as $route) {
            $middlewares = $route->gatherMiddleware();
            if (!in_array('auth', $middlewares) && str_starts_with($route->uri(), 'admin')) {
                $this->issues[] = "Route {$route->uri()} is missing auth middleware.";
            }
        }
        return $this->issues;
    }

    /**
     * Suggest caching for configs and routes
     */
    public function suggestCaching(): array
    {
        $suggestions = [];
        if (!file_exists(base_path('bootstrap/cache/config.php'))) {
            $suggestions[] = "Run `php artisan config:cache` for faster boot.";
        }
        if (!file_exists(base_path('bootstrap/cache/routes-v7.php'))) {
            $suggestions[] = "Run `php artisan route:cache` for faster route resolution.";
        }
        return $suggestions;
    }
}