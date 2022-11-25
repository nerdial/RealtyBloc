<?php

namespace App\Services\Engines\Fake;

use App\Contracts\EngineContract;
use App\Models\Engine;

class FakeEngine implements EngineContract
{

    public function __construct()
    {
    }


    public function execute()
    {
        $engine = Engine::first();
        if ($engine->status) {

            $fakeXml = new FakeXmlEngine($engine);
            $fakeXml->execute();
            $fakeJson = new FakeJsonEngine($engine);
            $fakeJson->execute();
            $fakeGraph = new FakeGraphEngine($engine);
            $fakeGraph->execute();

        }

    }


}
