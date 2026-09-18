<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $articles = Article::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->when($request->filled('category'), fn ($query) => $query->where('blog_category_id', $request->integer('category')))
            ->with(['author', 'blogCategory'])
            ->latest('published_at')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.articles.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Artikel'],
            ],
            'searchPlaceholder' => 'Cari judul, kategori, atau tag…',
            'searchAction' => route('admin.articles.index'),
            'articles' => $articles,
            'statuses' => PublishStatus::cases(),
            'categories' => BlogCategory::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Artikel', 'url' => route('admin.articles.index')],
                ['label' => 'Tambah'],
            ],
            'article' => new Article,
            'statuses' => PublishStatus::cases(),
            'authors' => User::orderBy('name')->get(),
            'categories' => BlogCategory::orderBy('name')->get(),
        ]);
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $data = $this->applyImageUploads($request, $request->validated(), ['featured_image_path'], 'articles');
        $data['author_id'] ??= auth()->id();

        if ($data['status'] === PublishStatus::Published->value && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if (! empty($data['blog_category_id']) && empty($data['category'])) {
            $data['category'] = BlogCategory::whereKey($data['blog_category_id'])->value('name');
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Artikel', 'url' => route('admin.articles.index')],
                ['label' => $article->title],
            ],
            'article' => $article,
            'statuses' => PublishStatus::cases(),
            'authors' => User::orderBy('name')->get(),
            'categories' => BlogCategory::orderBy('name')->get(),
        ]);
    }

    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $data = $this->applyImageUploads($request, $request->validated(), ['featured_image_path'], 'articles', $article);
        $data['author_id'] ??= auth()->id();

        if ($data['status'] === PublishStatus::Published->value && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if (! empty($data['blog_category_id']) && empty($data['category'])) {
            $data['category'] = BlogCategory::whereKey($data['blog_category_id'])->value('name');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->deleteImageFiles($article, ['featured_image_path']);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
