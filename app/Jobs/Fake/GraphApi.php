<?php

namespace App\Jobs\Fake;

use App\Helpers\FileUploader;
use App\Jobs\UpdateProperties;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GraphApi implements ShouldQueue
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
        $url = config('app.endpoints.fake.graph');

        $items = Http::post($url, [
            'query' => $this->generateQuery()
        ])->json('data.properties');

        $items = collect($items)->map(function ($item) {

            $fileName = FileUploader::uploadToS3($item['image']);

            $json = $this->createMetadata($item);

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

    private function createMetadata($item): array
    {
        return [
            'City' => $item['city'],
            'Height' => $item['height'],
            'Width' => $item['width']
        ];
    }

    private function generateQuery()
    {
        return "
        {
          properties {
            id, title, description, city, address, image, width , height, price, type
          }
        }";
    }
}
