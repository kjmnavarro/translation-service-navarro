<?php

namespace App\Services;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class TranslationService
{
    public function getTranslationsForExport(string $localeCode, array $tags = []): array
    {
        $cacheKey = "translations_export_{$localeCode}_" . implode('_', $tags);
        
        return Cache::remember($cacheKey, 60, function () use ($localeCode, $tags) {
            $query = Translation::with('tags')
                ->whereHas('locale', fn($q) => $q->where('code', $localeCode));
            
            if ($tags) {
                $query->whereHas('tags', fn($q) => $q->whereIn('name', $tags));
            }
            
            return $query->get()->mapWithKeys(fn($t) => [$t->key => $t->content])->toArray();
        });
    }

    public function search(array $filters): Collection
    {
        $query = Translation::with('locale', 'tags');
        
        if (isset($filters['key'])) {
            $query->where('key', 'like', '%' . $filters['key'] . '%');
        }
        if (isset($filters['content'])) {
            $query->where('content', 'like', '%' . $filters['content'] . '%');
        }
        if (isset($filters['tags'])) {
            $query->whereHas('tags', fn($q) => $q->whereIn('name', $filters['tags']));
        }
        
        return $query->get();
    }
}