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
        'bonus_balance',
        'profile_url',
        'email',
        'phone',
        'user_id',
        'status',
        'profile_id',
        'created_at',
        'updated_at'
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
        'created_at',
        'updated_at'
    ];

    /**
     * Установить access_token Авито.
     *
     * @param string $value
     * @return void
     */
    public function setAccessTokenAttribute($value)
    {
        $myEncrypter = new Encrypter('1234567812345678', 'AES-128-CBC');
        $this->attributes['access_token'] = $myEncrypter->encrypt($value);
    }

    /**
     * Получить access_token Авито.
     *
     * @param string $value
     * @return string
     */
    public function getAccessTokenAttribute()
    {
        $myEncrypter = new Encrypter('1234567812345678', 'AES-128-CBC');
        return "{$myEncrypter->decrypt($this->attributes['access_token'])}";
    }

    /**
     * Установить client_id Авито.
     *
     * @param string $value
     * @return void
     */
    public function setClientIdAttribute($value)
    {
        $myEncrypter = new Encrypter('1234567812345678', 'AES-128-CBC');
        $this->attributes['client_id'] = $myEncrypter->encrypt($value);
    }

    /**
     * Получить client_id Авито.
     *
     * @return string
     */
    public function getClientIdAttribute()
    {
        $myEncrypter = new Encrypter('1234567812345678', 'AES-128-CBC');
        return $myEncrypter->decrypt($this->attributes['client_id']);
    }

    /**
     * Установить client_secret Авито.
     *
     * @param string $value
     * @return void
     */
    public function setClientSecretAttribute($value)
    {
        $myEncrypter = new Encrypter('1234567812345678', 'AES-128-CBC');
        $this->attributes['client_secret'] = $myEncrypter->encrypt($value);
    }

    /**
     * Получить client_secret Авито.
     *
     * @param string $value
     * @return string
     */
    public function getClientSecretAttribute()
    {
        $myEncrypter = new Encrypter('1234567812345678', 'AES-128-CBC');
        return $myEncrypter->decrypt($this->attributes['client_secret']);
    }
}
