<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Product extends Model
{
	protected $primaryKey = 'product_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'product_id',
		'artist',
		'year',
		'album',
		'price',
		'store',
		'thumb',
		'date'
	];

	public function carts()
	{
		return $this->hasMany('App\Models\Cart');
	}

	public static function boot()
	{
		parent::boot();

		self::saving(function ($model) {
			if (preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/', $model->date)) {
				$model->date = join("-", array_reverse(explode("/", $model->date)));
			}
		});
	}
}
