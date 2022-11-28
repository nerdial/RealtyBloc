<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FakeDataJson;
use App\Models\FakeDataXml;
use App\Services\Engines\FakeEngine;


class FakeApiController extends Controller
{


    public function json()
    {
        return FakeDataJson::all();
    }


    public function xml()
    {
        $fake = FakeDataXml::all()
            ->map(fn($item) => ['item' => $item->toArray()])
            ->toArray();
        $data = [
            'status' => 'success',
            'items' => [
                $fake
            ]
        ];
        return response()->xml($data);

    }
}
