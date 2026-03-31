<?php

namespace Adeel3330\InsightGuard\Tests\Feature;

use Adeel3330\InsightGuard\Tests\TestCase;
use Illuminate\Support\Facades\Route;

class ExampleFeatureTest extends TestCase
{
    public function test_package_can_handle_basic_request()
    {
        Route::get('/dummy', function () {
            return response()->json(['message' => 'OK']);
        });

        $response = $this->get('/dummy');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'OK'
        ]);
    }

    public function test_insight_guard_binding_exists()
    {
        $this->assertTrue(app()->bound('insight-guard'));
    }

    public function test_security_analysis_runs_without_crashing()
    {
        if (!app()->bound('insight-guard')) {
            $this->markTestSkipped('InsightGuard not bound yet.');
        }

        $result = app('insight-guard')->analyzeSecurity();

        $this->assertIsArray($result);
    }

    public function test_performance_analysis_runs_without_crashing()
    {
        if (!app()->bound('insight-guard')) {
            $this->markTestSkipped('InsightGuard not bound yet.');
        }

        $result = app('insight-guard')->analyzePerformance();

        $this->assertIsArray($result);
    }

    public function test_database_analysis_runs_without_crashing()
    {
        if (!app()->bound('insight-guard')) {
            $this->markTestSkipped('InsightGuard not bound yet.');
        }

        $result = app('insight-guard')->analyzeDatabase();

        $this->assertIsArray($result);
    }

    public function test_code_optimization_runs_without_crashing()
    {
        if (!app()->bound('insight-guard')) {
            $this->markTestSkipped('InsightGuard not bound yet.');
        }

        $result = app('insight-guard')->analyzeCodeOptimization();

        $this->assertIsArray($result);
    }
}