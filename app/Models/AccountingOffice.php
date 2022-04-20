<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function clients(): HasMany {
        return $this->hasMany(Client::class);
    }

    public function subscription(): HasOne {
        return $this->hasOne(Subscription::class);
    }

    public function staff(): HasMany {
        return $this->hasMany(AccountingOfficeStaff::class);
    }
}
