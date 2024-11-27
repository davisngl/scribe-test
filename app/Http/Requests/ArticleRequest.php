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
		return [
			'title'       => ['required', 'min:3', 'max:255'],
			'description' => ['required', 'min:10', 'max:65_535'],
			'status'      => ['required', Rule::enum(ArticleStatus::class)],
		];
	}
}
