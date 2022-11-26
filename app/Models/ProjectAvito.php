<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ProjectAvito extends Model
{
  use HasApiTokens, HasFactory, Notifiable;
  public $timestamps = false;
  protected $table = 'projects';
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id',
    'name',
    'balance',
    'id_avito',
    'name',
    'profile_url',
    'email',
    'phone',
    'ads',
    'status'
  ];
  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'ads' => 'array'
  ];

  public function ads()
  {
    return $this->hasMany('App\Models\AdAvito');
  }
}
