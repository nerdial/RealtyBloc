<?php

namespace App\Services\Engines\Fake;

use App\Contracts\EngineContract;
use App\Helpers\FileUploader;
use App\Jobs\UpdateProperties;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;

class FakeGraphEngine implements EngineContract
{

    public function __construct(private Model $engine)
    {
    }

    public function execute()
    {
        $url = config('services.endpoints.fake.graph');
        $query = "
        {
          properties {
            id, title, description, city, address, image, width , height, price, type
          }
        }";

        $items = Http::post($url, [
            'query' => $query
        ])->json('data.properties');

        $items = collect($items)->map(function ($item)  {

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
