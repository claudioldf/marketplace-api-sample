<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Utils\ApiResponse;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\CreditCard;

class CartsController extends Controller
{

  /*
  * Use this method to add a new product to cart
  *
  * return text Json response
  */
  public function add_to_cart(Request $request)
  {
    $payload = $request->post();

    $this->validate($request, [
      'cart_id' => 'required',
      'client_id' => 'required',
      'product_id' => 'required',
      'date' => 'required|date_format:d/m/Y',
      'time' => 'required|date_format:H:i:s',
    ]);

    if (!Product::where('product_id', $payload['product_id'])->exists()) {
      return response()->json(ApiResponse::message('Produto informado não existe.'), 404);
    }

    if (Cart::where('cart_id', $payload['cart_id'])->where('product_id', $payload['product_id'])->exists()) {
      return response()->json(ApiResponse::message('Produto já foi adicionado no carrinho.'), 422);
    }

    $cart = new Cart($payload);
    if (!$cart->save()) {
      return response()->json(ApiResponse::message('Houve um erro ao adicionar este produto ao carrinho'), 422);
    }

    return response()->json([
      'message' => 'Produto adicionado ao carrinho com sucesso.'
    ], 201);
  }


  /*
  * Use this method to complete the order
  *
  * return text Json response
  */
  public function buy(Request $request)
  {
    $payload = $request->post();

    $this->validate($request, [
      'cart_id' => 'required',
      'client_id' => 'required',
      'client_name' => 'required',
      'value_to_pay' => 'required|integer',
      'credit_card.number' => 'required',
      'credit_card.cvv' => 'required',
      'credit_card.exp_date' => 'required|date_format:m/y',
      'credit_card.card_holder_name' => 'required'
    ]);

    $cart = Cart::find($payload['cart_id']);

    if (!$cart) {
      return response()->json(ApiResponse::message('Carrinho informado não existe.'), 404);
    }

    if ($cart->client_id != $payload['client_id']) {
      return response()->json(ApiResponse::message('Carrinho informado não pertence a este cliente.'), 422);
    }

    if ($cart->order) {
      return response()->json(ApiResponse::message('Compra já finalizada!'), 201);
    }

    try {
      \DB::beginTransaction();

      $creditCard = CreditCard::where('client_id', $cart->client_id)
        ->where('card_number', $payload['credit_card']['number'])
        ->where('exp_date', $payload['credit_card']['exp_date'])
        ->first();
      
      if (!$creditCard) {
        $creditCard = new CreditCard([
          'client_id' => $cart->client_id,
          'card_number' => CreditCard::obfuscateCardNumber($payload['credit_card']['number']),
          'exp_date' => $payload['credit_card']['exp_date'],
          'card_holder_name' => $payload['credit_card']['card_holder_name']
        ]);

        if (!$creditCard->save()) {
          return response()->json(ApiResponse::message('Falha ao salvar o cartão!'), 400);
        }
      }

      $order = new Order([
        'client_id' => $cart->client_id,
        'cart_id' => $cart->cart_id,
        'order_date' => date('Y-m-d'),
      ]);
      $order->save();

      $transaction = new Transaction([
        'order_id' => $order->order_id,
        'credit_card_id' => $creditCard->credit_card_id,
        'client_id' => $cart->client_id,
        'client_name' => $payload['client_name'],
        'value_to_pay' => $payload['value_to_pay']
      ]);
      $transaction->save();

      $order->push();

      \DB::commit();
    } catch (\Exception $e) {
      \DB::rollback();
      
      return response()->json(ApiResponse::message('Ocorreu uma falha ao finalizar a compra.'), 400);
    }

    return response()->json(ApiResponse::message('Compra finalizada com sucesso!'), 201);
  }
}
