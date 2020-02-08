<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use App\Utils\Uuid;

class Transaction extends Model
{
	protected $primaryKey = 'transaction_id';
	public $timestamps = false;

    protected $fillable = [
		'order_id',
		'client_id',
		'client_name',
		'value_to_pay',
		'credit_card_id'
	];
	
    public function creditCard()
    {
    	return $this->hasOne('App\Models\CreditCard');
	}
	
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
	}
	
	public static function boot()
	{
		parent::boot();

		self::creating(function ($model) {
			$model->transaction_id = (string)(new Uuid());
		});
	}
}