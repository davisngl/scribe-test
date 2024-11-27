<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
	use HandlesAuthorization;

	public function viewAny(User $user): bool
	{

	}

	public function view(User $user, Article $article): bool
	{
	}

	public function create(User $user): bool
	{
	}

	public function update(User $user, Article $article): bool
	{
	}

	public function delete(User $user, Article $article): bool
	{
	}

	public function restore(User $user, Article $article): bool
	{
	}

	public function forceDelete(User $user, Article $article): bool
	{
	}
}
