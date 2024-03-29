<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'title',
        'link',
        'icon',
        'parent_id',
        'permission_id',
        'status',
        'order'
    ];
}
