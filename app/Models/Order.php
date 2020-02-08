<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use App\Utils\Uuid;

class Order extends Model
{
	protected $primaryKey = 'order_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $hidden = ['created_at', 'updated_at'];

	protected $fillable = [
		'client_id',
		'cart_id',
		'order_date'
	];

	protected $dateFormat = 'm/d/Y';
	protected $casts = [
		'date' => 'date',
	];

	public function transaction()
	{
		return $this->hasOne('App\Models\Transaction');
	}

	public function creditCard()
	{
		return $this->hasOneThrough('App\Models\CreditCard', 'App\Models\Transaction');
	}

	public static function getList(array $filters = []) {
		return self::select([
			'orders.client_id',
			'orders.order_id',
			'credit_cards.card_number',
			'transactions.value_to_pay AS value',
			'orders.order_date AS date'
		])
		->join('transactions', 'transactions.order_id', '=', 'orders.order_id')
		->join('credit_cards', 'credit_cards.credit_card_id', '=', 'transactions.credit_card_id')
		->filters($filters)
		->get();
	}

	public function scopeFilters($query, array $filters = []) {
		if(isset($filters['client_id']) && !empty($filters['client_id'])) {
			$query->where('orders.client_id', $filters['client_id']);
		}
	}

	public static function boot()
	{
		parent::boot();

		self::creating(function ($model) {
			$model->order_id = (string)(new Uuid());
		});
	}
}
