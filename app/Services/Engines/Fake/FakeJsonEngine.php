<?php

namespace App\Services\Engines\Fake;

use App\Contracts\EngineContract;
use App\Jobs\UpdateProperties;
use App\Jobs\UploadImage;
use App\Models\Engine;
use App\Models\Property;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class FakeJsonEngine implements EngineContract
{

    public function execute()
    {

        $url = config('services.endpoints.fake.json');

        $items = Http::get($url)->json();


        $engine = Engine::first();

        $items = collect($items)->map(function ($item) use ($engine) {
            $item = $item['item'];

            $fileName = Str::random(20);

            Storage::disk('minio')
                ->put($fileName, file_get_contents($item['image']));

            $json = [
                'City' => $item['city'],
                'Height' => $item['height'],
                'Width' => $item['width']
            ];
            return [
                'entity_id' => $item['id'],
                'engine_id' => $engine->id,
                'title' => $item['title'],
                'address' => $item['address'],
                'image_address' => $fileName,
                'type' => $item['type'],
                'price' => $item['price'],
                'description' => $item['body'],
                'metadata' => json_encode($json)
            ];
        });

        UpdateProperties::dispatch($items->toArray());


    }


}
