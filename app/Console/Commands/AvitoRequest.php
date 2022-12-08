<?php

namespace App\Console\Commands;


use App\Components\Avito\AvitoApiComponent;
use App\Models\ProjectAvito;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AvitoRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avito:request';

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
        $project = ProjectAvito::all()->first();
        $aac = new AvitoApiComponent($project);
        print_r($aac->loadInfoProject());
    }
}
