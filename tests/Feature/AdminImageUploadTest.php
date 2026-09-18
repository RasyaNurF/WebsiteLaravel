<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_client_stores_the_uploaded_logo(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post(route('admin.clients.store'), [
                'name' => 'Bank Arta',
                'status' => 'active',
                'logo_path_file' => UploadedFile::fake()->image('logo.png', 400, 400),
            ])
            ->assertRedirect(route('admin.clients.index'));

        $client = Client::query()->firstOrFail();

        $this->assertNotNull($client->logo_path);
        $this->assertStringStartsWith('clients/', $client->logo_path);
        Storage::disk('public')->assertExists($client->logo_path);
    }

    public function test_updating_a_client_replaces_and_deletes_the_old_logo(): void
    {
        Storage::fake('public');

        $client = Client::create(['name' => 'Sinar Niaga', 'status' => 'active']);
        $admin = User::factory()->create();

        $this->actingAs($admin)->put(route('admin.clients.update', $client), [
            'name' => 'Sinar Niaga',
            'status' => 'active',
            'logo_path_file' => UploadedFile::fake()->image('old.png'),
        ]);

        $old = $client->fresh()->logo_path;
        Storage::disk('public')->assertExists($old);

        $this->actingAs($admin)->put(route('admin.clients.update', $client), [
            'name' => 'Sinar Niaga',
            'status' => 'active',
            'logo_path_file' => UploadedFile::fake()->image('new.png'),
        ]);

        $new = $client->fresh()->logo_path;

        $this->assertNotSame($old, $new);
        Storage::disk('public')->assertMissing($old);
        Storage::disk('public')->assertExists($new);
    }

    public function test_removing_a_client_logo_deletes_the_file(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();
        $client = Client::create(['name' => 'Sinar Niaga', 'status' => 'active']);

        $this->actingAs($admin)->put(route('admin.clients.update', $client), [
            'name' => 'Sinar Niaga',
            'status' => 'active',
            'logo_path_file' => UploadedFile::fake()->image('logo.png'),
        ]);

        $path = $client->fresh()->logo_path;
        Storage::disk('public')->assertExists($path);

        $this->actingAs($admin)->put(route('admin.clients.update', $client), [
            'name' => 'Sinar Niaga',
            'status' => 'active',
            'logo_path_remove' => '1',
        ]);

        $this->assertNull($client->fresh()->logo_path);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_upload_without_a_file_keeps_the_existing_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();
        $client = Client::create(['name' => 'Sinar Niaga', 'status' => 'active']);

        $this->actingAs($admin)->put(route('admin.clients.update', $client), [
            'name' => 'Sinar Niaga',
            'status' => 'active',
            'logo_path_file' => UploadedFile::fake()->image('logo.png'),
        ]);

        $path = $client->fresh()->logo_path;

        $this->actingAs($admin)->put(route('admin.clients.update', $client), [
            'name' => 'Sinar Niaga Baru',
            'status' => 'prospect',
        ]);

        $this->assertSame($path, $client->fresh()->logo_path);
        $this->assertSame('Sinar Niaga Baru', $client->fresh()->name);
        Storage::disk('public')->assertExists($path);
    }

    public function test_portfolio_thumbnail_upload_works(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post(route('admin.portfolios.store'), [
                'title' => 'Dashboard Keuangan',
                'status' => 'published',
                'thumbnail_path_file' => UploadedFile::fake()->image('thumb.webp', 1200, 800),
            ])
            ->assertRedirect(route('admin.portfolios.index'));

        $portfolio = Portfolio::query()->firstOrFail();

        $this->assertStringStartsWith('portfolios/', $portfolio->thumbnail_path);
        Storage::disk('public')->assertExists($portfolio->thumbnail_path);
    }

    public function test_deleting_a_client_removes_its_logo_file(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();
        $client = Client::create(['name' => 'Sinar Niaga', 'status' => 'active']);

        $this->actingAs($admin)->put(route('admin.clients.update', $client), [
            'name' => 'Sinar Niaga',
            'status' => 'active',
            'logo_path_file' => UploadedFile::fake()->image('logo.png'),
        ]);

        $path = $client->fresh()->logo_path;

        $this->actingAs($admin)->delete(route('admin.clients.destroy', $client));

        Storage::disk('public')->assertMissing($path);
    }

    public function test_rejects_a_non_image_upload(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post(route('admin.clients.store'), [
                'name' => 'Bank Arta',
                'status' => 'active',
                'logo_path_file' => UploadedFile::fake()->create('dokumen.pdf', 100),
            ])
            ->assertSessionHasErrors('logo_path_file');

        $this->assertSame(0, Client::query()->count());
    }

    public function test_service_without_any_image_field_still_works(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post(route('admin.services.store'), [
                'title' => 'Integrasi API',
                'status' => 'published',
            ])
            ->assertRedirect(route('admin.services.index'));

        $this->assertSame(1, Service::query()->count());
    }

    public function test_svg_avatar_upload_is_accepted_on_profile(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>';
        $path = tempnam(sys_get_temp_dir(), 'avatar').'.svg';
        file_put_contents($path, $svg);

        try {
            $this->actingAs($user)
                ->put(route('admin.profile.update'), [
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar_path_file' => new UploadedFile($path, 'avatar.svg', 'image/svg+xml', null, true),
                ])
                ->assertRedirect(route('admin.profile.edit'))
                ->assertSessionHasNoErrors();

            $this->assertNotNull($user->fresh()->avatar_path);
            Storage::disk('public')->assertExists($user->fresh()->avatar_path);
        } finally {
            @unlink($path);
        }
    }

    public function test_svg_logo_upload_is_accepted_for_clients(): void
    {
        Storage::fake('public');

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="24" height="24"/></svg>';
        $path = tempnam(sys_get_temp_dir(), 'logo').'.svg';
        file_put_contents($path, $svg);

        try {
            $this->actingAs(User::factory()->create())
                ->post(route('admin.clients.store'), [
                    'name' => 'Bank Arta',
                    'status' => 'active',
                    'logo_path_file' => new UploadedFile($path, 'logo.svg', 'image/svg+xml', null, true),
                ])
                ->assertRedirect(route('admin.clients.index'))
                ->assertSessionHasNoErrors();

            $client = Client::query()->firstOrFail();

            $this->assertStringEndsWith('.svg', $client->logo_path);
            Storage::disk('public')->assertExists($client->logo_path);
        } finally {
            @unlink($path);
        }
    }
}
