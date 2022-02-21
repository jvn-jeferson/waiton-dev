<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ClientUpload extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'client_uploads';

    protected $fillable = [
        'user_id',
        'file_id',
        'is_viewed',
        'comment'
    ];

    protected $filterable = [
        'user_id',
        'file_id',
        'is_viewed',
        'comment'
    ];

    protected $dates = ['deleted_at'];

    public function client(): HasOne {
        return $this->hasOne(Client::class);
    }

    public function user():HasOne {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function file():HasOne {
        return $this->hasOne(Files::class, 'id', 'file_id');
    }
}
