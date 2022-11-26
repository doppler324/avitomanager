<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Components\AvitoApiComponent;
use App\Http\Controllers\Api\CategoryAvitoController;
use App\Models\User;
use App\Models\AdAvito;

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
      $aac = new AvitoApiComponent();
      $aac->loadAds();
    }
}
