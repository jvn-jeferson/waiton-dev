<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $guarded = [];

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
}
