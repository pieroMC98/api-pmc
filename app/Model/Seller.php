<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    function product(){
        return $this->hasMany(Product::class);
    }
}
