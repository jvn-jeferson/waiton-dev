<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'accounting_office_staff_id',
        'client_id',
        'is_global',
        'notification_date',
        'subject',
        'details',
        'file_name',
        'file_path',
    ];
}
