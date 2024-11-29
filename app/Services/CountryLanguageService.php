<?php

namespace App\Services;

use App\Repositories\Contracts\FileRepositoryContract;

class CountryLanguageService
{
    private array $rawPayload = [];

    public function __construct(private FileRepositoryContract $countryLanguageRepository)
    {
        $this->rawPayload = $this->countryLanguageRepository->loadData();
    }

    public function getCountries(): array
    {
        return $this->rawPayload;
    }
}
