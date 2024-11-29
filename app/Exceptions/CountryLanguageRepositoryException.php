<?php

namespace App\Exceptions;

use Exception;

class CountryLanguageRepositoryException extends Exception
{
    public static function cannotOpenPayloadFile(): static
    {
        return new static('Cannot open country language payload file.');
    }
}
