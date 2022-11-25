<?php

namespace App\Console\Commands;

use App\Services\Engines;
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

        $fakeEngine = new Engines\FakeEngine();

        $fakeEngine->execute();

        $this->comment('Records have been updated successfully');

        return Command::SUCCESS;
    }
}
