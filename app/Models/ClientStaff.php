<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientStaff extends Model
{
    use HasFactory;

    protected $table = 'client_staffs';

    protected $fillable = [
        'client_id', 
        'user_id',
        'name',
        'is_admin'
    ];
}
