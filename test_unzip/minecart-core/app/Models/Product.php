<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title_id',
        'title_en',
        'description_id',
        'description_en',
        'price',
        'stock',
        'images',
        'address',
        'is_recommended',
        'condition',
        'weight',
        'sku',
        'is_flash_sale',
        'flash_sale_price',
        'flash_sale_start',
        'flash_sale_end',
        'flash_sale_stock',
    ];

    protected $casts = [
        'images' => 'array',
        'is_recommended' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
        'is_flash_sale' => 'boolean',
        'flash_sale_price' => 'integer',
        'flash_sale_start' => 'datetime',
        'flash_sale_end' => 'datetime',
        'flash_sale_stock' => 'integer',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order items for this product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the seller (user) that owns the product.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->images) || !isset($this->images[0])) {
            return asset('assets/logo-minecart.png');
        }
        $path = $this->images[0];
        return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/' . $path);
    }

    public function getAllImageUrlsAttribute()
    {
        if (empty($this->images)) {
            return [asset('assets/logo-minecart.png')];
        }
        return array_map(function ($path) {
            return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/' . $path);
        }, $this->images);
    }

    public function getIsFlashSaleActiveAttribute()
    {
        if (!$this->is_flash_sale || !$this->flash_sale_price) {
            return false;
        }

        if ($this->flash_sale_stock !== null && $this->flash_sale_stock <= 0) {
            return false;
        }

        $now = now();
        if ($this->flash_sale_start && $now->lt($this->flash_sale_start)) {
            return false;
        }

        if ($this->flash_sale_end && $now->gt($this->flash_sale_end)) {
            return false;
        }

        return true;
    }

    public function getCurrentPriceAttribute()
    {
        if ($this->is_flash_sale_active) {
            return $this->flash_sale_price;
        }
        return $this->price;
    }
}
