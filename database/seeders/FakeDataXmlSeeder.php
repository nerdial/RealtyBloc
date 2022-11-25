<?php

namespace Database\Seeders;

use App\Models\FakeDataXml;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeDataXmlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FakeDataXml::factory(2)->create();
    }
}
