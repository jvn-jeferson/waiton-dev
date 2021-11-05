<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'accounting_office_id',
        'subscription_plan_id',
        'stripe_id',
        'stripe_status',
        'quantity',
        'trial_ends',
        'customer_id',
        'trial_start',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
