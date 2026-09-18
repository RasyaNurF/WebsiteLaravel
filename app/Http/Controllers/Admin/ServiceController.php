<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $services = Service::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('admin.services.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Layanan'],
            ],
            'searchPlaceholder' => 'Cari nama atau deskripsi layanan…',
            'searchAction' => route('admin.services.index'),
            'services' => $services,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.services.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Layanan', 'url' => route('admin.services.index')],
                ['label' => 'Tambah'],
            ],
            'service' => new Service,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function store(ServiceRequest $request): RedirectResponse
    {
        Service::create($this->applyImageUploads($request, $request->validated(), ['image_path'], 'services'));

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Layanan', 'url' => route('admin.services.index')],
                ['label' => $service->title],
            ],
            'service' => $service,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function update(ServiceRequest $request, Service $service): RedirectResponse
    {
        $service->update($this->applyImageUploads($request, $request->validated(), ['image_path'], 'services', $service));

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->deleteImageFiles($service, ['image_path']);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
