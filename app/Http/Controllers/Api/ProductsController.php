<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Utils\ApiResponse;

class ProductsController extends Controller
{

  /*
  * Use this method to list all orders from database
  *
  * return text Json response
  */
  public function index()
  {
    $products = Product::all();

    return response()->json($products);
  }

  public function create(Request $request)
  {
    $payload = $request->post();

    $this->validate($request, [
      'product_id' => 'required|unique:products',
      'artist' => 'required',
      'year' => 'required|integer',
      'album' => 'required',
      'price' => 'required|integer',
      'store' => 'required',
      'thumb' => 'required|url',
      'date' => 'required',
    ]);

    if (Product::where('product_id', $payload['product_id'])->exists()) {
      return response()->json(ApiResponse::message('Já existe um produto com este ID.'), 422);
    }

    $product = new Product($payload);
    if (!$product->save()) {
      return response()->json(ApiResponse::message('Houve um erro ao criar o produto.'), 422);
    }

    return response()->json(ApiResponse::message('Produto criado com sucesso.'), 201);
  }
}
