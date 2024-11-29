<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ArticleStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
	public function rules(): array
	{
		$ruleset = [
			'title'       => ['required', 'min:3', 'max:255'],
			'description' => ['required', 'min:10', 'max:65535'],
			'status'      => ['required', Rule::enum(ArticleStatus::class)],
		];

        if (request()->routeIs('articles.store')) {
            $ruleset['title'][] = 'unique:articles,title';
        } else {
            // On update requests, we can ignore being unique against itself.
            $ruleset['title'][] = Rule::unique('articles', 'title')->ignore($this->route('article')->id);
        }

        return $ruleset;
	}
}
