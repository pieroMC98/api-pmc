<?php

namespace App\Model;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;
	public $transformer = CategoryTransformer::class;
	protected $table = 'category';
	protected $dates = ['deleted_at'];
	protected $fillable = ['name', 'brief'];
	protected $hidden = ['pivot'];
	function product()
	{
		return $this->belongsToMany(Product::class);
	}
}
