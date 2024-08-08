<?php

namespace Database\Seeders;

use App\Models\Images\Enums\ServerTypeEnum;
use App\Models\Images\ImageGenerateServer;
use App\Models\Images\ImageGenerateServerTypePivot;
use Illuminate\Database\Seeder;

class ImageGenerateServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createModel('generate1.ai-generate.com', [
            ServerTypeEnum::Crawler->value,
            ServerTypeEnum::Generator->value,
        ]);
        $this->createModel('generate2.ai-generate.com', [
            ServerTypeEnum::Crawler->value,
            ServerTypeEnum::Generator->value,
        ]);
    }

    private function createModel(string $host, array $types): void
    {
        $model = ImageGenerateServer::create([
            'host'    => $host,
            'enabled' => true,
        ]);
        collect($types)->each(function ($type) use ($model) {
            ImageGenerateServerTypePivot::create([
                'image_generate_server_id'        => $model->id,
                'image_generate_server_type_code' => $type,
            ]);
        });
    }
}
