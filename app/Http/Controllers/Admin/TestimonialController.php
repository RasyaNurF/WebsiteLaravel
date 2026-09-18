<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $testimonials = Testimonial::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->orderByDesc('is_featured')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.testimonials.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Testimonial'],
            ],
            'searchPlaceholder' => 'Cari nama, perusahaan, atau kutipan…',
            'searchAction' => route('admin.testimonials.index'),
            'testimonials' => $testimonials,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.testimonials.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Testimonial', 'url' => route('admin.testimonials.index')],
                ['label' => 'Tambah'],
            ],
            'testimonial' => new Testimonial,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function store(TestimonialRequest $request): RedirectResponse
    {
        Testimonial::create([
            ...$this->applyImageUploads($request, $request->validated(), ['photo_path'], 'testimonials'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Testimonial', 'url' => route('admin.testimonials.index')],
                ['label' => $testimonial->name],
            ],
            'testimonial' => $testimonial,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update([
            ...$this->applyImageUploads($request, $request->validated(), ['photo_path'], 'testimonials', $testimonial),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->deleteImageFiles($testimonial, ['photo_path']);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil dihapus.');
    }
}
