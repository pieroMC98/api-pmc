<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Product extends Model
{
    const AVAILABLE = true;
    const NOTAVAILABLE = false;
    protected $fillable = [
        'name',
        'brief',
        'status',
        'image',
        'seller_id'
    ];

    function is_available(){
        return $this->status == self::AVAILABLE;
    }
    function category(){
        return $this->belongsToMany(Category::class);
    }

    function seller(){
        return $this->belongsTo(Seller::class);
    }
    function transaction(){
        return $this->belongsToMany(Category::class);
    }
}
