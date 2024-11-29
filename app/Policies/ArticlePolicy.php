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
        /**
         * Normally, we should be having some sort of logic involving user permissions,
         * but for the sake of example, this will do.
         */
        return true;
    }

    public function view(User $user, Article $article): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function restore(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function forceDelete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }
}
