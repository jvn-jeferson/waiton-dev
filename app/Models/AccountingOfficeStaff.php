<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountingOfficeStaff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'accounting_office_staffs';

    protected $fillable = [
        'accounting_office_id',
        'user_id',
        'name',
        'is_admin'
    ];

    protected $dates = ['deleted_at'];

    public function accountingOffice() : HasOne {
        return $this->hasOne(AccountingOffice::class, 'id', 'accounting_office_id');
    }

    public function user() : HasOne {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
