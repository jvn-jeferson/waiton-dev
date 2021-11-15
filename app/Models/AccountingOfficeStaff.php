<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function accounting_office() : HasOne {
        return $this->hasOne(AccountingOffice::class);
    }

    public function user() : HasOne {
        return $this->hasOne(User::class);
    }
}
