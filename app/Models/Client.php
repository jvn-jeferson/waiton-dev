<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'user_id',
        'accounting_office_id',
        'name',
        'buiness_type_id',
        'address',
        'telephone',
        'representative',
        'tax_filing_month',
        'nta_num',
        'temporary_password',
        'notify_on_ids'
    ];
}
