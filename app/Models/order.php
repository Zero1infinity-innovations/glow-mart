<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    // Add shop_id to the fillable array
    protected $fillable = [
        'user_id',
        'product_ids',
        'username',
        'order_number',
        'total_amount',
        'discount',
        'tax_amount',
        'final_amount',
        'shop_id', // Add this line
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    
}
