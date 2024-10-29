<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'image',
        'name',
        'slug',
        'price',
        'stocks',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function getAvailableStocksAttribute()
    {
        // Deduct the quantity of items already ordered from the stock
        $orderedQuantity = $this->orderItems()->sum('quantity');

        return $this->stocks - $orderedQuantity;
    }
}
