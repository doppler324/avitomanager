<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GroupsProjectsModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = 'groups_projects';

    protected $fillable = [
        'id',
        'name',
        'user_id',
    ];
}
