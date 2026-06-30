<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        $now = now();
        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }

        if ($this->valid_until && $now->gt($this->valid_until)) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($subtotal)
    {
        if ($subtotal < $this->min_purchase) {
            return 0;
        }

        if ($this->type === 'fixed') {
            return min($this->value, $subtotal);
        }

        // type === 'percent'
        $discount = $subtotal * ($this->value / 100);

        if ($this->max_discount !== null && $discount > $this->max_discount) {
            return $this->max_discount;
        }

        return min($discount, $subtotal);
    }
}
