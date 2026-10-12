<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'user_id',
        'method',
        'gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'gateway_signature',
        'amount',
        'status',
        'response',
        'proof_document',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
