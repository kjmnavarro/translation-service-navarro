<?php

namespace Tests\Feature;

use App\Models\Locale;
use App\Models\Tag;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_translation()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $locale = Locale::factory()->create(['code' => 'en']);
        $tag = Tag::factory()->create(['name' => 'mobile']);

        $response = $this->withHeaders(['Authorization' => "Bearer {$token}"])
            ->postJson('/api/translations', [
                'key' => 'hello',
                'locale_id' => $locale->id,
                'content' => 'Hello World',
                'tags' => [$tag->id]
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('translations', ['key' => 'hello']);
    }

    public function test_export_performance()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        Translation::factory()->count(1000)->create();

        $start = microtime(true);
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->getJson('/api/translations/export?locale=en');
        $end = microtime(true);

        $response->assertStatus(200);
        $this->assertLessThan(0.5, $end - $start);
    }
}