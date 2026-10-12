<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Order extends Model
{
    protected $fillable = [
        'order_no',
        'user_id',
        'address_id',
        'subtotal',
        'discount',
        'shipping',
        'total',
        'notes',
        'discount_percentage',
        'cgst_percentage',
        'cgst',
        'sgst_percentage',
        'sgst',
        'igst_percentage',
        'igst',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class, 'order_id')
            ->orderBy('created_at')
            ->orderBy('id');
    }

}
