<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use App\Utils\Uuid;

class CreditCard extends Model
{
	protected $primaryKey = 'credit_card_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'client_id',
		'card_number',
		'card_holder_name',
		'cvv',
		'exp_date'
	];

	public static function obfuscateCardNumber($card_number) 
	{
		return join(" ", [str_repeat("*", 4), str_repeat("*", 4) , str_repeat("*", 4), substr($card_number, 12, 4)]);
	}

	public static function boot()
	{
		parent::boot();

		self::creating(function ($model) {
			$model->credit_card_id = (string)(new Uuid());
		});
	}
}