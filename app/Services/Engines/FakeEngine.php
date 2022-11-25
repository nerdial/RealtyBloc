<?php

namespace App\Services\Engines;

use App\Contracts\EngineContract;
use App\Jobs\Fake\GraphApi;
use App\Jobs\Fake\RestApi;
use App\Jobs\Fake\XmlApi;
use App\Models\Engine;

class FakeEngine implements EngineContract
{

    public function __construct()
    {
    }


    public function execute()
    {
        $engine = Engine::where('key', 'fakeServer')->first();
        if ($engine->status) {
            GraphApi::dispatch($engine);
            RestApi::dispatch($engine);
            XmlApi::dispatch($engine);
        }
    }


}
