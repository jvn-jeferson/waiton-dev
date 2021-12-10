<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TaxationHistory extends Model
{
    use HasFactory;

    protected $table = 'taxation_histories';

    protected $fillable = [
        'user_id',
        'client_id',
        'settlement_date',
        'file_id',
        'recognition_date',
        'proposal_date',
        'company_representative',
        'accounting_office_staff',
        'video_contributor',
        'comment',
        'kinds',
        'video_url'
    ];

    protected $dates = ['deleted_at', 'settlement_date', 'recognition_date', 'proposal_date'];

    public function file(): HasOne
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }


}
