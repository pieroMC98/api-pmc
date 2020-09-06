<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'quantify','buyer_id','product_id'
    ];
    function buyer(){
        return $this->belongsTo(Buyer::class);
    }

    function product(){ return $this->belongsTo(Product::class); }
}

