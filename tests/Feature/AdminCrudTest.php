<?php

namespace Tests\Feature;

use App\Enums\LeadStatus;
use App\Enums\PublishStatus;
use App\Models\Client;
use App\Models\Portfolio;
use App\Models\ProjectInquiry;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_a_lead_status(): void
    {
        $admin = User::factory()->create();

        $lead = ProjectInquiry::create([
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'project_type' => 'Aplikasi Web',
            'project_detail' => 'Butuh aplikasi kasir.',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.leads.update', $lead), [
                'name' => 'Budi',
                'email' => 'budi@example.com',
                'project_type' => 'Aplikasi Web',
                'project_detail' => 'Butuh aplikasi kasir.',
                'status' => LeadStatus::Deal->value,
                'admin_note' => 'Sudah tanda tangan kontrak.',
            ])
            ->assertRedirect(route('admin.leads.show', $lead));

        $lead->refresh();

        $this->assertSame(LeadStatus::Deal, $lead->status);
        $this->assertSame($admin->id, $lead->handled_by);
        $this->assertNotNull($lead->handled_at);
    }

    public function test_lead_can_be_updated_with_status_and_note_only(): void
    {
        $admin = User::factory()->create();

        $lead = ProjectInquiry::create([
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'project_type' => 'Aplikasi Web',
            'project_detail' => 'Butuh aplikasi kasir.',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.leads.update', $lead), [
                'status' => LeadStatus::Dihubungi->value,
                'admin_note' => 'Sudah dihubungi via telepon.',
            ])
            ->assertRedirect(route('admin.leads.show', $lead))
            ->assertSessionHasNoErrors();

        $this->assertSame(LeadStatus::Dihubungi, $lead->refresh()->status);
    }

    public function test_lead_update_requires_a_valid_status(): void
    {
        $admin = User::factory()->create();

        $lead = ProjectInquiry::create([
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'project_type' => 'Aplikasi Web',
            'project_detail' => 'Butuh aplikasi kasir.',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.leads.update', $lead), [
                'name' => 'Budi',
                'email' => 'budi@example.com',
                'status' => 'tidak-ada',
            ])
            ->assertSessionHasErrors('status');
    }

    public function test_admin_can_create_a_client_and_slug_is_generated(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.clients.store'), [
                'name' => 'Bank Arta Nusantara',
                'industry' => 'Keuangan',
                'status' => 'active',
            ])
            ->assertRedirect(route('admin.clients.index'));

        $this->assertDatabaseHas('clients', [
            'name' => 'Bank Arta Nusantara',
            'slug' => 'bank-arta-nusantara',
        ]);
    }

    public function test_deleting_a_client_detaches_projects(): void
    {
        $admin = User::factory()->create();
        $client = Client::create(['name' => 'Sinar Niaga', 'status' => 'active']);

        $project = $client->projects()->create([
            'name' => 'Portal Pelaporan',
            'status' => 'development',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.clients.destroy', $client))
            ->assertRedirect(route('admin.clients.index'));

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
        $this->assertNull($project->refresh()->client_id);
    }

    public function test_admin_can_create_a_portfolio(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.portfolios.store'), [
                'title' => 'Dashboard Keuangan Internal',
                'category' => 'Perbankan',
                'status' => PublishStatus::Published->value,
                'technologies' => 'Laravel, MySQL',
                'year' => 2025,
                'is_featured' => 1,
            ])
            ->assertRedirect(route('admin.portfolios.index'));

        $portfolio = Portfolio::query()->firstWhere('slug', 'dashboard-keuangan-internal');

        $this->assertNotNull($portfolio);
        $this->assertTrue($portfolio->is_featured);
        $this->assertSame(PublishStatus::Published, $portfolio->status);
    }

    public function test_slugs_stay_unique(): void
    {
        $admin = User::factory()->create();

        foreach ([1, 2] as $attempt) {
            $this->actingAs($admin)->post(route('admin.services.store'), [
                'title' => 'Pengembangan Aplikasi Web',
                'status' => PublishStatus::Published->value,
            ]);
        }

        $this->assertSame(2, Service::query()->count());
        $this->assertDatabaseHas('services', ['slug' => 'pengembangan-aplikasi-web']);
        $this->assertDatabaseHas('services', ['slug' => 'pengembangan-aplikasi-web-2']);
    }
}
