<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_editor_can_open_content_but_not_users(): void
    {
        $editor = User::factory()->editor()->create();

        $this->actingAs($editor)->get(route('admin.articles.index'))->assertOk();
        $this->actingAs($editor)->get(route('admin.portfolios.index'))->assertOk();
        $this->actingAs($editor)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($editor)->get(route('admin.settings.edit'))->assertForbidden();
    }

    public function test_admin_can_open_operations_but_not_users(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get(route('admin.leads.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.projects.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_super_admin_can_open_everything(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        foreach (['admin.users.index', 'admin.settings.edit', 'admin.seo.index', 'admin.media.index'] as $route) {
            $this->actingAs($superAdmin)->get(route($route))->assertOk();
        }
    }

    public function test_inactive_user_is_denied_access(): void
    {
        $user = User::factory()->superAdmin()->create(['is_active' => false]);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }
}
