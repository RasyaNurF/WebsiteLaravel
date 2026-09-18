<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceModeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_site_is_unavailable_when_maintenance_mode_is_on(): void
    {
        SiteSetting::put('maintenance_mode', '1');

        $this->get('/')
            ->assertStatus(503)
            ->assertSee('pemeliharaan', false);
    }

    public function test_admin_can_still_browse_while_maintenance_mode_is_on(): void
    {
        SiteSetting::put('maintenance_mode', '1');

        $admin = User::factory()->superAdmin()->create();

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get('/')->assertOk();
    }
}
