<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category_old extends Model
{
    protected $fillable = [
        'category_name',
        'slug',
        'seo_title',
        'seo_description',
        'gmc_category',
        'category_image',
        'status',
    ];
}
