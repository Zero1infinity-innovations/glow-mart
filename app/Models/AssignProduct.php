<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignProduct extends Model
{
    protected $table = 'assign_products';
    protected $fillable = [
        'shop_id',
        'product_id',
        'quantity',
    ];

    // public function product(): BelongsTo
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
