<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

  /*
  * Use this method to lista all orders
  *
  * Opcionaly, you can pass a GET param called client_id, to filter orders
  * from by the specific client_id
  *
  * return text Json response
  */
  public function index(Request $request)
  {
    $filters = [
      'client_id' => $request->route('client_id')
    ];

    $orders = Order::getList($filters);

    return response()->json($orders);
  }

}
