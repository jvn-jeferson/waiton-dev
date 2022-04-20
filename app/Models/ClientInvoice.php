<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class ClientInvoice extends Model
{
    use HasFactory;

    protected $table = 'client_invoices';

    protected $fillable = [
        'amount_due',
        'accounting_office_id',
        'invoice_number',
        'payment_invoice_status',
        'subscription_id',
        'payment_plan_id',
        'token',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function subscription(): belongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
