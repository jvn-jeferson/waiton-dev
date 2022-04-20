<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneTimePassword extends Model
{
    use HasFactory;

    protected $table = 'one_time_passwords';

    protected $fillable = [
        'password',
        'target_table',
        'record_id'
    ]; 

    protected $dates = ['deleted_at'];
}
