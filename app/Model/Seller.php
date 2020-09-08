<?php

namespace App;

class Seller extends User
{
 //   protected $table = 'seller';
    function product(){
        return $this->hasMany(Product::class);
    }
}
