<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RegenerateIDEHelperData extends Command
{
    protected $signature = 'ide-helper:regenerate';

    protected $description = 'Regenerate PHPStorm IDE helper data to improve editor knowledge of Laravel magic methods etc.';

    public function handle(): void
    {
        if (app()->environment(['production'])) {
            $this->warn('Command can only be called outside production environment!');

            return;
        }

        Artisan::call('ide-helper:eloquent');
        Artisan::call('ide-helper:generate -W');
        Artisan::call('ide-helper:meta');
        Artisan::call('ide-helper:models -M');

        $this->info('IDE Helper data regenerated!');
    }
}
