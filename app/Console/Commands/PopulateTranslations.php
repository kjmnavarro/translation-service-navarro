<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;

class PopulateTranslations extends Command
{
    protected $signature = 'translations:populate {count=100000}';
    protected $description = 'Populate the database with translations for testing';

    public function handle()
    {
        $count = $this->argument('count');
        Translation::factory()->count($count)->create();
        $this->info("Created {$count} translations.");
    }
}
