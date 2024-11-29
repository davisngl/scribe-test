<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\FileRepositoryContract;
use App\Repositories\CountryLanguageRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            abstract: FileRepositoryContract::class,
            concrete: CountryLanguageRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        $isProduction = app()->isProduction();

        // Unwrap resources
        JsonResource::withoutWrapping();

        // Model specifics
        Model::unguard();

        Model::preventAccessingMissingAttributes(! $isProduction);
        Model::preventLazyLoading(! $isProduction);
        Model::preventSilentlyDiscardingAttributes(! $isProduction);

        // Command safety
        DB::prohibitDestructiveCommands($isProduction);
    }
}
