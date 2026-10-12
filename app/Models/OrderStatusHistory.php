<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusHistory extends Model
{
    protected $table = 'order_status_history';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'status',
        'title',
        'description',
        'location',
        'created_by',
        'created_at',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
