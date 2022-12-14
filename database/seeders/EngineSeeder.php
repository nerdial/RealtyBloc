<?php

namespace Database\Seeders;

use App\Models\Engine;
use App\Services\Engines\FakeEngine;
use Illuminate\Database\Seeder;

class EngineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Engine::create([
            'title' => 'Fake Server',
            'class_name' => 'fakeApi:run',
            'status' => 1,
            'key' => 'fakeServer',
            'rate_limit' => 20
        ]);

    }
}
