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
        'client_id',
        'client_staff_id',
        'file_name',
        'file_path',
        'file_size',
        'comment'
    ];

    protected $filterable = [
        'client_id',
        'client_staff_id',
        'file_name',
        'file_path',
        'file_size',
        'comment'
    ];

    protected $dates = ['deleted_at'];

    public function client(): HasOne {
        return $this->hasOne(Client::class);
    }
}
