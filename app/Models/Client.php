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

    protected $fillable = [
        'accounting_office_id',
        'name',
        'buiness_type_id',
        'address',
        'representative',
        'representative_address',
        'contact_email',
        'tax_filing_month',
    ];

    public function users():HasMany
    {
        return $this->hasMany(ClientStaff::class);
    }
}
