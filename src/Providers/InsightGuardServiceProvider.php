<?php

namespace Adeel3330\InsightGuard\Providers;

use Illuminate\Support\ServiceProvider;
use Adeel3330\InsightGuard\Commands\RunInsightScan;

class InsightGuardServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge default config
        $this->mergeConfigFrom(__DIR__.'/../../config/insightguard.php', 'insightguard');

        // Register command
        $this->app->singleton('command.insightguard.scan', RunInsightScan::class);
        $this->commands([
            'command.insightguard.scan',
        ]);
    }

    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../../config/insightguard.php' => config_path('insightguard.php'),
        ], 'config');

        // Publish dashboard views
        $this->loadViewsFrom(__DIR__.'/../../src/Dashboard/Views', 'insightguard');

        // Load routes for dashboard
        $this->loadRoutesFrom(__DIR__.'/../../src/Dashboard/Routes/web.php');
    }
}