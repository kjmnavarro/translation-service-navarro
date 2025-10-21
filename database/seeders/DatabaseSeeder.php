<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Locale;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Locale::factory()->create(['code' => 'en']);
        Locale::factory()->create(['code' => 'fr']);
        Locale::factory()->create(['code' => 'es']);

        Tag::factory()->create(['name' => 'mobile']);
        Tag::factory()->create(['name' => 'desktop']);
        Tag::factory()->create(['name' => 'web']);
    }
}
