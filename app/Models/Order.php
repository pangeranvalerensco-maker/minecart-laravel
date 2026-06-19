<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'fullname',
        'phone',
        'address',
        'city',
        'postal_code',
        'courier_note',
        'subtotal',
        'shipping_cost',
        'total',
        'payment_method',
        'payment_status',
        'status',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'shipping_cost' => 'integer',
        'total' => 'integer',
    ];

    /**
     * Get the order items for this order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
