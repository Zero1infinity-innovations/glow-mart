<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'banner_type','image','status'
    ];


    public function getBannerTypeAttribute($value){
        return ucwords($value);
    }
}
