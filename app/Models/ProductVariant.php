<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';
    protected $fillable = ['product_id', 'size', 'color', 'material', 'variant_name', 'sku', 'sale_price', 'mrp_price', 'quantity', 'image'];
}
