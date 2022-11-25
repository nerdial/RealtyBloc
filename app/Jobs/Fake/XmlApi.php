<?php

namespace App\Jobs\Fake;

use App\Helpers\FileUploader;
use App\Helpers\XmlHandler;
use App\Jobs\UpdateProperties;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class XmlApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Model $engine)
    {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = config('app.endpoints.fake.xml');

        $xmlContent = Http::get($url)->body();

        $items = XmlHandler::convertToArray($xmlContent, 'items');

        $items = collect($items)->map(function ($item) {
            $item = $item['item'];

            $fileName = FileUploader::uploadToS3($item['image_address']);

            $json = $this->createMetadata($item);

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

    private function createMetadata(array $item): array
    {
        return [
            'Country' => $item['country'],
            'Height' => $item['height'],
            'Width' => $item['width'],
            'Lat' => $item['lat'],
            'Lng' => $item['lng']
        ];
    }
}
