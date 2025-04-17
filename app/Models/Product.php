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
    public function getGalleryImagesAttribute($value)
    {
        // Decode the JSON value from the database into a PHP array
        $images = json_decode($value, true);
        
        // If images are found, process each image and replace backslashes with forward slashes
        if ($images) {
            return array_map(fn($img) => str_replace('\\', '/', $img), $images);
        }
        
        // Return empty array if no images are found
        return [];
    }
}
