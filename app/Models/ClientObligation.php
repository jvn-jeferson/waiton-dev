<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientObligation extends Model
{
    use HasFactory;

    protected $table = "client_obligations";

    protected $fillable = [
        'client_id',
        'is_taxable',
        'calculation_method',
        'taxable_type'
    ];
}
