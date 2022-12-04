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
    'client_id',
    'client_secret',
    'profile_url',
    'email',
    'phone',
    'status'
  ];
}
