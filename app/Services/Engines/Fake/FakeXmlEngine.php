<?php

namespace App\Services\Engines\Fake;

use App\Contracts\EngineContract;
use App\Helpers\FileUploader;
use App\Helpers\XmlHandler;
use App\Jobs\UpdateProperties;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;


class FakeXmlEngine implements EngineContract
{

    public function __construct(private Model $engine)
    {
    }

    public function execute()
    {

        $url = config('services.endpoints.fake.xml');

        $xmlContent = Http::get($url)->body();

        $items = XmlHandler::convertToArray($xmlContent, 'items');

        $items = collect($items)->map(function ($item) {
            $item = $item['item'];

            $fileName = FileUploader::uploadToS3($item['image_address']);

            $json = [
                'Country' => $item['country'],
                'Height' => $item['height'],
                'Width' => $item['width'],
                'Lat' => $item['lat'],
                'Lng' => $item['lng']
            ];
            return [
                'entity_id' => $item['id'],
                'engine_id' => $this->engine->id,
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
