<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'unit',
        'image',
        'multi_image',
        'slug',
        'seo_title',
        'seo_description',
        'category_id',
        'status'
    ];

    protected $casts = [
        'multi_image' => 'array'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
