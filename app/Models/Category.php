<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'category_name', 
        'category_dis', 
        'category_image',
        'menu_item',
    ];
    
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'parent_cate_id');
    }

}
