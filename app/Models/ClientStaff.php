<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientStaff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_staffs';

    protected $fillable = [
        'client_id',
        'user_id',
        'name',
        'is_admin'
    ];

    protected $dates = ['deleted_at'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
}
