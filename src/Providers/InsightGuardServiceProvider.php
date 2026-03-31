<?php

namespace Adeel3330\InsightGuard\Providers;

use Illuminate\Support\ServiceProvider;
use Adeel3330\InsightGuard\Services\InsightGuardManager;
use Adeel3330\InsightGuard\Commands\RunInsightScan;

class InsightGuardServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge config safely
        if (file_exists(__DIR__ . '/../../config/insightguard.php')) {
            $this->mergeConfigFrom(
                __DIR__ . '/../../config/insightguard.php',
                'insightguard'
            );
        }

        // Bind main service
        $this->app->singleton('insight-guard', function ($app) {
            return new InsightGuardManager();
        });

        // Register command (only in console)
        if ($this->app->runningInConsole()) {
            $this->app->singleton(RunInsightScan::class, function ($app) {
                return new RunInsightScan();
            });

            $this->commands([
                RunInsightScan::class,
            ]);
        }
    }

    public function boot()
    {
        // Publish config
        if (file_exists(__DIR__ . '/../../config/insightguard.php')) {
            $this->publishes([
                __DIR__ . '/../../config/insightguard.php' => config_path('insightguard.php'),
            ], 'insightguard-config');
        }

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../Dashboard/Views', 'insightguard');

        // Load routes (only for web, not console)
        if (! $this->app->runningInConsole()) {
            $this->loadRoutesFrom(__DIR__ . '/../Dashboard/Routes/web.php');
        }
    }
}