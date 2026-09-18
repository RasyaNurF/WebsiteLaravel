<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeoRequest;
use App\Models\SeoMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $seo = SeoMeta::query()
            ->search($request->string('q')->toString())
            ->paginate(20)
            ->withQueryString();

        return view('admin.seo.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'SEO'],
            ],
            'searchPlaceholder' => 'Cari path, label, atau judul…',
            'searchAction' => route('admin.seo.index'),
            'seo' => $seo,
        ]);
    }

    public function create(): View
    {
        return view('admin.seo.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'SEO', 'url' => route('admin.seo.index')],
                ['label' => 'Tambah'],
            ],
            'seo' => new SeoMeta,
        ]);
    }

    public function store(SeoRequest $request): RedirectResponse
    {
        SeoMeta::create([
            ...$this->applyImageUploads($request, $request->validated(), ['og_image_path'], 'seo'),
            'is_indexable' => $request->boolean('is_indexable'),
        ]);

        return redirect()->route('admin.seo.index')->with('success', 'SEO berhasil ditambahkan.');
    }

    public function edit(SeoMeta $seo): View
    {
        return view('admin.seo.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'SEO', 'url' => route('admin.seo.index')],
                ['label' => $seo->label],
            ],
            'seo' => $seo,
        ]);
    }

    public function update(SeoRequest $request, SeoMeta $seo): RedirectResponse
    {
        $seo->update([
            ...$this->applyImageUploads($request, $request->validated(), ['og_image_path'], 'seo', $seo),
            'is_indexable' => $request->boolean('is_indexable'),
        ]);

        return redirect()->route('admin.seo.index')->with('success', 'SEO berhasil diperbarui.');
    }

    public function destroy(SeoMeta $seo): RedirectResponse
    {
        $this->deleteImageFiles($seo, ['og_image_path']);
        $seo->delete();

        return redirect()->route('admin.seo.index')->with('success', 'SEO berhasil dihapus.');
    }
}
