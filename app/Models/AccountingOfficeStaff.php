<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingOfficeStaff extends Model
{
    use HasFactory;

    protected $table = 'accounting_office_staffs';

    protected $fillable = [
        'accounting_office_id', 
        'user_id',
        'name',
        'is_admin'
    ];
}
