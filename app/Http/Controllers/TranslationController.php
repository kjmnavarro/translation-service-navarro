<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class TranslationController extends Controller
{
    protected TranslationService $service;

    public function __construct(TranslationService $service)
    {
        $this->service = $service;
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['key', 'content', 'tags']);
        return response()->json($this->service->search($filters));
    }

    public function show(Translation $translation)
    {
        return response()->json($translation->load('locale', 'tags'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string',
            'locale_id' => 'required|exists:locales,id',
            'content' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $translation = Translation::create($request->only(['key', 'locale_id', 'content']));
        $translation->tags()->attach($request->tags ?? []);
        
        Cache::flush();
        
        return response()->json($translation, 201);
    }

    public function update(Request $request, Translation $translation)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'string',
            'locale_id' => 'exists:locales,id',
            'content' => 'string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $translation->update($request->only(['key', 'locale_id', 'content']));
        $translation->tags()->sync($request->tags ?? []);
        
        Cache::flush();
        
        return response()->json($translation);
    }

    public function export(Request $request)
    {
        $locale = $request->query('locale', 'en');
        $tags = $request->query('tags', []);
        
        $data = $this->service->getTranslationsForExport($locale, $tags);
        
        return response()->json($data);
    }
}
