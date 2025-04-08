<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{

    protected $table = 'shops';
    protected $fillable = [
        'shop_image',
        'shop_name',
        'owner_name',
        'owner_email',
        'address',
        'city',
        'state',
        'pincode',
        'aadhar_number',
        'pan_number',
        'phone_number',
        'shop_status',
    ];
}
