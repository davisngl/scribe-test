<?php

namespace App\Services;

use App\Repositories\Contracts\FileRepositoryContract;
use Illuminate\Contracts\Cache\Repository;

readonly class CountryLanguageService
{
    private array $rawPayload;

    public function __construct(
        private FileRepositoryContract $countryLanguageRepository,
        private Repository $cache,
    ) {
        $this->rawPayload = $this->cache->remember(
            key: 'country_language', // these should be saved in enums/static constants tho
            ttl: static fn($items) => count($items) ? 0 : -1,
            callback: function () {
                return collect($this->countryLanguageRepository->loadData())
                    ->keyBy('country')
                    ->toArray();
            }
        );
    }

    public function getCountries(): array
    {
        return $this->cache->remember(
            key: 'countries',
            ttl: static fn($items) => count($items) ? 0 : -1,
            callback: function () {
                return collect($this->rawPayload)
                    ->keyBy('country')
                    ->keys()
                    ->toArray();
            },
        );
    }

    public function getLanguages(string $country): array
    {
        return $this->rawPayload[$country]['languages'] ?? [];
    }
}
