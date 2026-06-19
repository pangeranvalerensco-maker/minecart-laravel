<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'title_id',
        'title_en',
        'description_id',
        'description_en',
        'price',
        'stock',
        'images',
        'seller_name',
        'address',
        'is_recommended',
    ];

    protected $casts = [
        'images' => 'array',
        'is_recommended' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
