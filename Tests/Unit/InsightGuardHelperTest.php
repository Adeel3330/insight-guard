<?php

namespace Adeel3330\InsightGuard\Tests\Unit;

use Adeel3330\InsightGuard\Tests\TestCase;
use Illuminate\Http\Request;

class InsightGuardHelperTest extends TestCase
{
    public function test_basic_assertion_works()
    {
        $this->assertTrue(true);
    }

    public function test_request_instance_can_be_created()
    {
        $request = Request::create('/test', 'POST', [
            'name' => 'Adeel'
        ]);

        $this->assertEquals('Adeel', $request->input('name'));
    }

    public function test_app_container_is_working()
    {
        $this->assertNotNull(app());
    }
}