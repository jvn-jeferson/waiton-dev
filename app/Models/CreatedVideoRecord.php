<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CreatedVideoRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'created_video_records';

    protected $fillable = [
        'user_id',
        'client_id',
        'video_url',
    ];

    protected $dates = ['deleted_at'];

    public function contributor() : HasOne
    {
        return $this->hasOne(User::class);
    }

    public function client() : HasOne
    {
        return $this->hasOne(Client::class);
    }
}
