<?php

namespace App\Jobs;

use App\Models\CategoryAvito;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Components\AvitoApiComponent;

class JobAvitoAdsDownloading implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle()
    {

      $ads = AvitoApiComponent::loadAds();
      if(empty($ads)){
        return "Объявления не найдены на странице";
      }
      return "Все объявления добавлены";
    }
}
