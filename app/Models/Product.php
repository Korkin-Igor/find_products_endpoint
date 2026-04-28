<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'in_stock',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
