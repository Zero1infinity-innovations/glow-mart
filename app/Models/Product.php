<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table  = 'products';
    protected $fillable = [
        'product_name',
        'sale_price',
        'mrp_price',
        'quantity',
        'product_image',
        'product_gallery',
        'category',
        'subCategory',
        'product_status',
        'payment_method',
        'description',
    ];

    public function categoryName(){
        return $this->belongsTo(Category::class, 'category', 'id');
    }
}
