<?php

namespace Database\Seeders;

use App\Models\Images\ImageGenerateServerType;
use Illuminate\Database\Seeder;

class ImageGenerateServerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createModel('crawler', 'can crawl');
        $this->createModel('generator', 'can generate');
    }

    private function createModel(string $code, string $description): void
    {
        ImageGenerateServerType::firstOrCreate([
            'code' => $code,
            'description' => $description,
        ]);
    }
}
