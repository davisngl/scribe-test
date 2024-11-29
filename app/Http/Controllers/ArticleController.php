<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', Article::class);

        return Inertia::render('Articles/Index', [
            'articles' => fn () => ArticleResource::collection(
                Article::query()
                    ->with('author:id,name')
                    ->select('id', 'user_id', 'status', 'title', 'description', 'created_at')
                    ->when(
                        value: !$request->query('sortDirection'),
                        callback: static fn(Builder $query) => $query->latest(),
                    )
                    ->when(
                        value: $request->query('status'),
                        callback: static function (Builder $query, string $status) {
                            if ($status === 'any') {
                                return $query;
                            }

                            return $query->where('status', $status);
                        },
                    )
                    ->when(
                        value: $request->query('date'),
                        callback: static fn(Builder $query, string $date) => $query->whereDate('created_at', $date),
                    )
                    ->when(
                        value: $request->query('sortDirection'),
                        callback: static fn(Builder $query, string $sortDirection) => $query->orderBy('created_at',
                            $sortDirection),
                    )
                    ->simplePaginate($request->query('per_page', 10))
                    ->withQueryString()
            ),
            'existingFilters' => $request->only(['status', 'date', 'sortDirection']),
        ]);
    }

    public function create(): Response
    {
        Gate::authorize('create', Article::class);

        return Inertia::render('Articles/Create');
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        Gate::authorize('create', Article::class);

        auth()->user()->articles()->create($request->validated());

        return back()->with('success', 'Article created successfully');
    }

    public function show(Article $article)
    {
        Gate::authorize('view', $article);

        return Inertia::render('Articles/Show', [
            'article' => ArticleResource::make($article->load('author:id,name')),
        ]);
    }

    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        return Inertia::render('Articles/Edit', [
            'article' => $article,
        ]);
    }

    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        Gate::authorize('update', $article);

        $article->update($request->validated());

        return to_route('articles.index')->with('success', 'Article updated successfully');
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();

        return to_route('articles.index')->with('success', 'Article deleted successfully');
    }
}
