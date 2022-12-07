<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ProjectAvito extends Model
{
    use HasFactory;

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
        'profile_url',
        'email',
        'phone',
        'user_id',
        'status',
        'profile_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'access_token',
        'access_token_time',
        'client_id',
        'client_secret',
    ];

    /**
     * Установить access_token Авито.
     *
     * @param  string  $value
     * @return void
     */
    public function setAccessTokenAttribute($value)
    {
        $myEncrypter = new Encrypter('1234567812345678', 'AES-128-CBC');
        $this->attributes['access_token'] = $myEncrypter->encrypt($value);
        unset($myEncrypter);
    }

    /**
     * Получить access_token Авито.
     *
     * @param  string  $value
     * @return string
     */
    public function getAccessTokenAttribute()
    {
        $myEncrypter = new Encrypter('1234567812345678', 'AES-128-CBC');
        Text::with(['author'=>function($q){
            $q->makeVisible('name');
        }])->get();
        return $this->makeVisible(['access_token']);
       // return "{$myEncrypter->decrypt($this->makeVisible(['access_token']))}";
    }
}
