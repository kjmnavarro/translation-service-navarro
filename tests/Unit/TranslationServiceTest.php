<?php

namespace Tests\Unit;

use App\Models\Locale;
use App\Models\Tag;
use App\Models\Translation;
use App\Services\TranslationService;
use Tests\TestCase;

class TranslationServiceTest extends TestCase
{
    public function test_get_translations_for_export()
    {
        $locale = Locale::factory()->create(['code' => 'en']);
        $tag = Tag::factory()->create(['name' => 'mobile']);
        $translation = Translation::factory()->create(['locale_id' => $locale->id]);

        $translation->tags()->attach($tag);
        
        $service = new TranslationService();
        $data = $service->getTranslationsForExport('en', ['mobile']);
        
        $this->assertIsArray($data);
        $this->assertArrayHasKey($translation->key, $data);
    }
}