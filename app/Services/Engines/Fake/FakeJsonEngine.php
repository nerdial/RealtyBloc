<?php

namespace App\Services\Engines\Fake;

use App\Contracts\EngineContract;
use App\Helpers\FileUploader;
use App\Jobs\UpdateProperties;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;


class FakeJsonEngine implements EngineContract
{

    public function __construct(private Model $engine)
    {
    }


    public function execute()
    {

        $url = config('services.endpoints.fake.json');
        $items = Http::get($url)->json();

        $items = collect($items)->map(function ($item){

            $fileName = FileUploader::uploadToS3($item['image']);

            $json = [
                'City' => $item['city'],
                'Height' => $item['height'],
                'Width' => $item['width']
            ];
            return [
                'entity_id' => $item['id'],
                'engine_id' => $this->engine->id,
                'title' => $item['title'],
                'address' => $item['address'],
                'image_address' => $fileName,
                'type' => $item['type'],
                'price' => $item['price'],
                'description' => $item['description'],
                'metadata' => json_encode($json)
            ];
        });

        UpdateProperties::dispatch($items->toArray());
    }


}
