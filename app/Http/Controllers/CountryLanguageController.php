<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryLanguagesRequest;
use App\Services\CountryLanguageService;
use Illuminate\Http\JsonResponse;

class CountryLanguageController extends Controller
{
    public function __invoke(
        CountryLanguagesRequest $request,
        CountryLanguageService $countryLanguageService
    ): JsonResponse {
        return response()->json(
            $countryLanguageService->getLanguages(
                country: $request->validated('country')
            )
        );
    }
}
