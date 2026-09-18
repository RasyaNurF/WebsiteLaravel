<?php

namespace Tests\Feature;

use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_an_image_to_the_media_library(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.media.store'), [
                'file' => UploadedFile::fake()->image('banner.jpg', 1200, 800),
                'alt_text' => 'Banner promosi',
            ])
            ->assertRedirect(route('admin.media.index'));

        $media = Media::query()->first();

        $this->assertNotNull($media);
        $this->assertSame('banner.jpg', $media->original_name);
        $this->assertSame('Banner promosi', $media->alt_text);
        $this->assertSame($admin->id, $media->uploaded_by);
        $this->assertStringStartsWith('image/', $media->mime_type);

        Storage::disk('public')->assertExists($media->path);
    }

    public function test_upload_rejects_disallowed_file_types(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post(route('admin.media.store'), [
                'file' => UploadedFile::fake()->create('script.exe', 100),
            ])
            ->assertSessionHasErrors('file');

        $this->assertSame(0, Media::query()->count());
    }

    public function test_deleting_media_removes_the_file(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.media.store'), [
            'file' => UploadedFile::fake()->image('foto.png', 200, 200),
        ]);

        $media = Media::query()->firstOrFail();

        $this->actingAs($admin)
            ->delete(route('admin.media.destroy', $media))
            ->assertRedirect(route('admin.media.index'));

        Storage::disk('public')->assertMissing($media->path);
        $this->assertSame(0, Media::query()->count());
    }

    public function test_editor_can_update_alt_text(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->editor()->create())->post(route('admin.media.store'), [
            'file' => UploadedFile::fake()->image('gambar.webp', 300, 300),
        ]);

        $media = Media::query()->firstOrFail();

        $this->actingAs($media->uploaded_by ? User::find($media->uploaded_by) : User::factory()->editor()->create())
            ->put(route('admin.media.update', $media), ['alt_text' => 'Alt baru', 'title' => 'Judul'])
            ->assertRedirect();

        $media->refresh();

        $this->assertSame('Alt baru', $media->alt_text);
        $this->assertSame('Judul', $media->title);
    }
}
