<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PastNotification extends Model
{
    use HasFactory;

    protected $table = 'past_notifications';

    protected $fillable = [
        'user_id',
        'client_id',
        'proposal_date',
        'recognition_date',
        'file_id'
    ];

    protected $dates = ['proposal_date', 'recognition_date'];
    
    public function file(): HasOne
    {
        return $this->hasOne(Files::class, 'id', 'file_id');
    }
}
