<?php
namespace App\Utils;

class ApiResponse
{
	public static function message($message)
	{
		return [
			'message' => $message
		];
	}
}
