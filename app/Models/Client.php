<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clients';

    public const MONTHS = [
        '1' => '1月',
        '2' => '2月',
        '3' => '3月',
        '4' => '4月',
        '5' => '5月',
        '6' => '6月',
        '7' => '7月',
        '8' => '8月',
        '9' => '9月',
        '10' => '10月',
        '11' => '11月',
        '12' => '12月'
    ];

    protected $fillable = [
        'accounting_office_id',
        'name',
        'business_type_id',
        'address',
        'representative',
        'representative_address',
        'contact_email',
        'tax_filing_month',
    ];

    function setValue($month)
    {
        $this->value = $month;
    }

    public function staffs(): HasMany
    {
        return $this->hasMany(ClientStaff::class);
    }

    public function credentials(): HasOne
    {
        return $this->hasOne(TaxingCredentials::class);
    }

    public function notifs() : HasOne
    {
        return $this->hasOne(ClientMajorNotification::class);
    }

    public function obligation(): HasOne
    {
        return $this->hasOne(ClientObligation::class);
    }

    public function host(): hasOne
    {
        return $this->hasOne(AccountingOffice::class, 'id', 'accounting_office_id');
    }
}
