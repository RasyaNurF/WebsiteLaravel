<?php

namespace App\Http\Controllers\Public;

use App\Enums\PublishStatus;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $categories = BlogCategory::query()
            ->where('status', PublishStatus::Published->value)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $articles = Article::query()
            ->where('status', PublishStatus::Published->value)
            ->when($request->filled('kategori'), fn ($query) => $query->whereHas('blogCategory', fn ($q) => $q->where('slug', $request->string('kategori')->toString())))
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->string('q')->toString();
                $query->where(fn ($q) => $q->where('title', 'like', "%{$term}%")->orWhere('excerpt', 'like', "%{$term}%"));
            })
            ->with(['blogCategory', 'author'])
            ->orderByDesc('published_at')
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        return view('blog.index', [
            'articles' => $articles,
            'categories' => $categories,
            'activeCategory' => $request->string('kategori')->toString() ?: null,
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless($article->status === PublishStatus::Published, 404);

        $article->load(['blogCategory', 'author']);

        $related = Article::query()
            ->where('status', PublishStatus::Published->value)
            ->whereKeyNot($article->id)
            ->when($article->blog_category_id, fn ($query) => $query->where('blog_category_id', $article->blog_category_id))
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', [
            'article' => $article,
            'related' => $related,
        ]);
    }
}
