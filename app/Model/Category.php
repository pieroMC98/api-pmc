<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;
	protected $table = 'category';
	protected $dates = ['deleted_at'];
	protected $fillable = ['name', 'brief'];
	protected $hidden = ['pivot'];
	function product()
	{
		return $this->belongsToMany(Product::class);
	}
}
