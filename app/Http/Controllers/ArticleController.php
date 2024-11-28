<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class ArticleController extends Controller
{
	public function index(Request $request): Response
	{
        return inertia('Articles/Index', [
            'articles' => Article::query()
                ->with(['author:id,name as author_name'])
                ->latest()
                ->select(['id', 'title', 'author.id', 'author.name as author_name', 'created_at'])
                ->paginate($request->query('per_page', 10)),
        ]);
	}

	public function create(): Response
	{
        return inertia('Articles/Create');
	}

	public function store(StoreArticleRequest $request): RedirectResponse
	{
        Article::create($request->validated());

        return back()->with('success', 'Article created successfully');
	}

	public function show(Article $article)
	{
        return inertia('Articles/Show', ['article' => $article]);
	}

	public function edit(Article $article)
	{
        return inertia('Articles/Edit', ['article' => $article]);
	}

	public function update(StoreArticleRequest $request, Article $article): RedirectResponse
	{
        $article->update($request->validated());

        return back()->with('success', 'Article updated successfully');
	}

	public function destroy(Article $article)
	{
        $article->delete();

        return back()->with('success', 'Article deleted successfully');
	}
}
