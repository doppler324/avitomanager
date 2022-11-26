<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAvito extends Model
{
  use HasFactory;

  public $timestamps = false;
  public $table = 'categories';

  protected $fillable = [
    'id',
    'name',
    'avito_id',
    'parent_category_id',
    'depth_level'
  ];
}
