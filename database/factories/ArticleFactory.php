<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ArticleFactory extends Factory
{
	protected $model = Article::class;

	public function definition(): array
	{
		return [
			'title'       => $this->faker->realText(100),
			'description' => $this->faker->realText(1000),
			'status'      => Arr::random(ArticleStatus::cases()),
			'created_at'  => Carbon::now(),
			'updated_at'  => Carbon::now(),
		];
	}
}
