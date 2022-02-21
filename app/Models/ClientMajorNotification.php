<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientMajorNotification extends Model
{
    use HasFactory;

    protected $table = 'client_major_notifications';

    protected $fillable = [
        'client_id',
        'establishment_notification',
        'blue_declaration',
        'withholding_tax',
        'salary_payment',
        'extension_filing_deadline',
        'consumption_tax',
        'consumption_tax_excemption',
        'consumption_tax_selection'
    ];

    
}
