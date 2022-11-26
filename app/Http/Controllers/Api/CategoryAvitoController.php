<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryAvito;
use App\Jobs\JobAvitoAdsDownloading;

class CategoryAvitoController extends Controller
{
  /**
   *  Добавление категорий на сайт
   * @return void
   */
  public static function loadCategories(): void
  {
    JobAvitoAdsDownloading::dispatch()->onQueue('categories');
  }
}
