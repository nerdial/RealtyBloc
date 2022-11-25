<?php

namespace Database\Seeders;

use App\Models\FakeDataJson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeDataJsonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FakeDataJson::factory(2)->create();
    }
}
