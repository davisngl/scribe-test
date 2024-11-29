<?php

namespace App\Repositories;

use App\Exceptions\CountryLanguageRepositoryException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class CountryLanguageRepository implements Contracts\FileRepositoryContract
{
	public function getFilePath(): string
	{
		return resource_path( 'data/country-language.json');
	}

    /**
     * @throws CountryLanguageRepositoryException
     */
    public function loadData(): ?array
	{
        try {
            return File::json($this->getFilePath());
        } catch (FileNotFoundException) {
            throw CountryLanguageRepositoryException::cannotOpenPayloadFile();
        }
	}
}
