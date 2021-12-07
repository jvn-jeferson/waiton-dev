<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HostUpload extends Model
{
    use HasFactory;

    protected $table = 'host_uploads';

    protected $fillable = [
        'user_id',
        'client_id',
        'file_id',
        'status',
        'priority',
        'details'
    ];

    protected $dates = ['deleted_at'];

    public function file() : HasOne
    { 
       return $this->hasOne(File::class, 'id', 'file_id');
    }

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
