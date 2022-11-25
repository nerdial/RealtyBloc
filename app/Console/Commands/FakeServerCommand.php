<?php

namespace App\Console\Commands;

use App\Services\Engines\Fake\FakeEngine;
use Illuminate\Console\Command;

class FakeServerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fakeApi:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $fakeEngine = new FakeEngine();

        $fakeEngine->execute();


        return Command::SUCCESS;
    }
}
