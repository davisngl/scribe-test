<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Articles/Index', [
            'articles' => ArticleResource::collection(
                Article::query()
                    ->with('author:id,name')
                    ->latest()
                    ->select('id', 'user_id', 'status', 'title', 'description', 'created_at')
                    ->paginate($request->query('per_page', 10))
                    ->withQueryString()
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Articles/Create');
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        auth()->user()->articles()->create($request->validated());

        return back()->with('success', 'Article created successfully');
    }

    public function show(Article $article)
    {
        return Inertia::render('Articles/Show', [
            'article' => ArticleResource::make($article->load('author:id,name')),
        ]);
    }

    public function edit(Article $article)
    {
        return Inertia::render('Articles/Edit', [
            'article' => $article,
        ]);
    }

    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $article->update($request->validated());

        return to_route('articles.index')->with('success', 'Article updated successfully');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return to_route('articles.index')->with('success', 'Article deleted successfully');
    }
}
