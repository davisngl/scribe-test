<?php

namespace App\Repositories\Contracts;

interface FileRepositoryContract
{
    public function getFilePath(): string;

    public function loadData();
}
