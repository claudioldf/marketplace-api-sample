<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Cart extends Model
{
	protected $primaryKey = 'cart_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'cart_id',
		'client_id',
		'product_id',
		'date',
		'time'
	];

	public function product()
	{
		return $this->belongsTo('App\Models\Product');
	}

	public function creditCard()
	{
		return $this->hasOne('App\Models\CreditCard');
	}

	public function order()
	{
		return $this->hasOne('App\Models\Order', 'cart_id', 'cart_id');
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
