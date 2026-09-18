<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = BlogCategory::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->withCount('articles')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.blog-categories.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Kategori Blog'],
            ],
            'searchPlaceholder' => 'Cari nama kategori…',
            'searchAction' => route('admin.blog-categories.index'),
            'categories' => $categories,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.blog-categories.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Kategori Blog', 'url' => route('admin.blog-categories.index')],
                ['label' => 'Tambah'],
            ],
            'category' => new BlogCategory,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function store(BlogCategoryRequest $request): RedirectResponse
    {
        BlogCategory::create($request->validated());

        return redirect()->route('admin.blog-categories.index')->with('success', 'Kategori blog berhasil ditambahkan.');
    }

    public function edit(BlogCategory $blogCategory): View
    {
        return view('admin.blog-categories.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Kategori Blog', 'url' => route('admin.blog-categories.index')],
                ['label' => $blogCategory->name],
            ],
            'category' => $blogCategory,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->update($request->validated());

        return redirect()->route('admin.blog-categories.index')->with('success', 'Kategori blog berhasil diperbarui.');
    }

    public function destroy(BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->articles()->update(['blog_category_id' => null]);
        $blogCategory->delete();

        return redirect()->route('admin.blog-categories.index')->with('success', 'Kategori blog berhasil dihapus.');
    }
}
