<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'user_id',
        'accounting_office_id',
        'accounting_office_staff_id',
        'is_global',
        'targeted_at',
        'posted_at',
        'scheduled_at',
        'contents',
        'file_id'
    ];

}
