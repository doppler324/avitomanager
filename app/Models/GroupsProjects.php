<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GroupsProjects extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = 'groups_projects';

    protected $fillable = [
        'id',
        'name',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        # Проверка данных пользователя перед сохранением
        static::saving(function($groupsprojects)  // Функция обработчика в качестве аргумента принимает объект модели
        {
            // Проверяем количество групп пользователя
            if ( $groupsprojects->where('user_id', Auth::id())->count() >= 10 ) return false; // Отменяем операцию сохранения

        });
        # Выполняем действия после сохранения
        static::saved(function($groupsprojects)
        {
            // Посылаем сообщение с регистрационными данными
        });
    }
}
