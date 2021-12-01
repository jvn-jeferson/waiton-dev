<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientUpload extends Model
{
    use HasFactory;

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
        'file_name',
        'file_path',
        'file_size',
        'comment'
    ];

    public function client(): HasOne {
        return $this->hasOne(Client::class);
    }
}
