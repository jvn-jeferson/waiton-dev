<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingOffice extends Model
{
    use HasFactory;

    protected $table = 'accounting_offices';

    protected $fillable = [
        'name',
        'user_id',
        'representative',
        'address',
        'telephone',
        'contact_email',
        'temporary_password',
    ];

    protected $filterable = [
        'name',
        'user_id',
        'representative',
        'address',
        'contact_email'
    ];
}
