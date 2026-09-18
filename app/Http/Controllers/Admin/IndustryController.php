<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndustryRequest;
use App\Models\Industry;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndustryController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $industries = Industry::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->withCount('services')
            ->orderBy('sort_order')
            ->paginate(15)
            ->withQueryString();

        return view('admin.industries.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Industri'],
            ],
            'searchPlaceholder' => 'Cari nama atau deskripsi industri…',
            'searchAction' => route('admin.industries.index'),
            'industries' => $industries,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.industries.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Industri', 'url' => route('admin.industries.index')],
                ['label' => 'Tambah'],
            ],
            'industry' => new Industry,
            'statuses' => PublishStatus::cases(),
            'services' => Service::orderBy('title')->get(),
            'selectedServices' => [],
        ]);
    }

    public function store(IndustryRequest $request): RedirectResponse
    {
        $industry = Industry::create($this->applyImageUploads($request, $request->validated(), ['image_path'], 'industries'));
        $industry->services()->sync($request->input('services', []));

        return redirect()->route('admin.industries.index')->with('success', 'Industri berhasil ditambahkan.');
    }

    public function edit(Industry $industry): View
    {
        return view('admin.industries.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Industri', 'url' => route('admin.industries.index')],
                ['label' => $industry->name],
            ],
            'industry' => $industry,
            'statuses' => PublishStatus::cases(),
            'services' => Service::orderBy('title')->get(),
            'selectedServices' => $industry->services()->pluck('services.id')->all(),
        ]);
    }

    public function update(IndustryRequest $request, Industry $industry): RedirectResponse
    {
        $industry->update($this->applyImageUploads($request, $request->validated(), ['image_path'], 'industries', $industry));
        $industry->services()->sync($request->input('services', []));

        return redirect()->route('admin.industries.index')->with('success', 'Industri berhasil diperbarui.');
    }

    public function destroy(Industry $industry): RedirectResponse
    {
        $this->deleteImageFiles($industry, ['image_path']);
        $industry->services()->detach();
        $industry->delete();

        return redirect()->route('admin.industries.index')->with('success', 'Industri berhasil dihapus.');
    }
}
