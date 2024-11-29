<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Test user 1', 'email' => 'test1@example.com'],
            ['name' => 'Test user 2', 'email' => 'test2@example.com'],
            ['name' => 'Test user 3', 'email' => 'test3@example.com'],
            ['name' => 'Test user 4', 'email' => 'test4@example.com'],
            ['name' => 'Test user 5', 'email' => 'test5@example.com']
        ];
        $onePasswordToRuleThemAll = Hash::make('password');

        $users = collect($users)
            ->map(
                static fn (array $user) => User::factory()->create(array_merge($user, ['password' => $onePasswordToRuleThemAll]))
            );

        Article::factory(count: 100)
            ->recycle($users)
            ->create();
    }
}
