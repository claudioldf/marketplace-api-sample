<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
  return "You cann't access by this way!";
});

$router->group(['prefix' => 'store/'], function($router) {
  $router->group(['prefix' => 'api/'], function($router) {
    $router->group(['prefix' => 'v1/'], function($router) {
      // product
      $router->group(['prefix' => 'product/'], function() use ($router) {
        $router->post('/', 'Api\ProductsController@create');
      });

      // products
      $router->group(['prefix' => 'products/'], function() use ($router) {
        $router->get('/', ['uses' => 'Api\ProductsController@index', 'as' => 'products']);
        $router->get('/{product_id}', 'Api\ProductsController@show');
      });

      // carts
      $router->post('/add_to_cart', 'Api\CartsController@add_to_cart');
      $router->post('/buy', 'Api\CartsController@buy');

      // history
      $router->get('/history/{client_id}', 'Api\OrdersController@index');
      $router->get('/history', 'Api\OrdersController@index');
    });
  });
});
