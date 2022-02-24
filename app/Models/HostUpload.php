<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HostUpload extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'host_uploads';

    protected $fillable = [
        'user_id',
        'client_id',
        'file_id',
        'status',
        'priority',
        'details',
        'modified_by_user_id',
        'video_url'
    ];

    protected $dates = ['deleted_at'];

    public function file() : HasOne
    {
       return $this->hasOne(Files::class, 'id', 'file_id');
    }

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function editor() : HasOne
    {
        return $this->hasOne(ClientStaff::class, 'user_id', 'modified_by_user_id');
    }
}
