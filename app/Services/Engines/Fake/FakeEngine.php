<?php

namespace App\Services\Engines\Fake;

use App\Contracts\EngineContract;

class FakeEngine implements EngineContract
{

    public function __construct()
    {
    }


    public function execute()
    {

        $fakeXml = new FakeXmlEngine();

        $fakeJson = new FakeJsonEngine();

        $fakeXml->execute();

        $fakeJson->execute();


    }


}
