<?php

use App\Http\Controllers\CountryLanguageController;
use Illuminate\Support\Facades\Route;

Route::post('countries/get-languages', CountryLanguageController::class)
    ->middleware('throttle:60,1')
    ->name('countries.get-languages');
