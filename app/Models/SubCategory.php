<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'subcategories';
    protected $fillable = [
        'parent_cate_id', 
        'subcate_name', 
        'subcate_image',
        'subcate_discription',
        'sub_menu_item'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_cate_id');
    }
}
