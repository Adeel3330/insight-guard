<?php

namespace Adeel3330\InsightGuard\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Adeel3330\InsightGuard\Providers\InsightGuardServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            InsightGuardServiceProvider::class,
        ];
    }

    /**
     * Set up environment.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Example: Use in-memory SQLite DB
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}