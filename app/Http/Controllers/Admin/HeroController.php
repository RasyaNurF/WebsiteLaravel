<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroRequest;
use App\Models\Hero;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $heroes = Hero::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.heroes.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Hero'],
            ],
            'searchPlaceholder' => 'Cari judul hero…',
            'searchAction' => route('admin.heroes.index'),
            'heroes' => $heroes,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.heroes.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Hero', 'url' => route('admin.heroes.index')],
                ['label' => 'Tambah'],
            ],
            'hero' => new Hero,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function store(HeroRequest $request): RedirectResponse
    {
        Hero::create($this->applyImageUploads($request, $request->validated(), ['image_path'], 'heroes'));

        return redirect()->route('admin.heroes.index')->with('success', 'Hero berhasil ditambahkan.');
    }

    public function edit(Hero $hero): View
    {
        return view('admin.heroes.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Hero', 'url' => route('admin.heroes.index')],
                ['label' => $hero->title],
            ],
            'hero' => $hero,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function update(HeroRequest $request, Hero $hero): RedirectResponse
    {
        $hero->update($this->applyImageUploads($request, $request->validated(), ['image_path'], 'heroes', $hero));

        return redirect()->route('admin.heroes.index')->with('success', 'Hero berhasil diperbarui.');
    }

    public function destroy(Hero $hero): RedirectResponse
    {
        $this->deleteImageFiles($hero, ['image_path']);
        $hero->delete();

        return redirect()->route('admin.heroes.index')->with('success', 'Hero berhasil dihapus.');
    }
}
