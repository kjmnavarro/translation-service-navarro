<?php

namespace Database\Factories;

use App\Models\Locale;
use App\Models\Tag;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition()
    {
        return [
            'key' => $this->faker->unique()->uuid,
            'locale_id' => function () {
                $locale = Locale::inRandomOrder()->first();
                if (!$locale) {
                    $locale = Locale::factory()->create();
                }
                return $locale->id;
            },
            'content' => $this->faker->sentence,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Translation $translation) {
            $tags = Tag::inRandomOrder()->take(rand(1, 3))->get();

            if ($tags->count() < 1) {
                $tags = Tag::factory()->count(rand(1, 3))->create();
            }
            
            $translation->tags()->attach($tags);
        });
    }

}
