<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TaxingCredentials extends Model
{
    use HasFactory;

    protected $table = 'taxing_credentials';

    protected $fillable = [
        'client_id',
        'nta_id',
        'nta_password',
        'el_tax_id',
        'el_tax_password'
    ];

    public function client(): HasOne {
        return $this->hasOne(Client::class);
    }
}
