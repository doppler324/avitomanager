<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdAvito extends Model
{
  use HasApiTokens, HasFactory, Notifiable;

  public $timestamps = false;
  public $table = 'ads';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id',
    'price',
    'user_id',
    'status',
    'title',
    'url',
    'category_id',
    'project_id'
  ];
}
