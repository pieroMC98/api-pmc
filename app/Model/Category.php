<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;
	protected $table = 'category';
	protected $dates = ['deleted_at'];
	protected $fillable = ['name', 'brief'];
	function product()
	{
		return $this->belongsToMany(Product::class);
	}
}
