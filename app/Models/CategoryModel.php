<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'avito_id',
        'avito_parent_id',
        'depth_level'
    ];
}
