<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'brief'
    ];
    function product(){
        return $this->belongsToMany(Product::class);
    }
}
