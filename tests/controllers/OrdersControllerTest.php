<?php
use Laravel\Lumen\Testing\DatabaseMigrations;

class OrdersControllerTest extends TestCase
{
  use DatabaseMigrations;

  /**
   * testShouldReturnAllOrders
   *
   * @return void
   */
  public function testShouldReturnAllOrders()
  {
    $credit_card = factory('App\Models\CreditCard')->create([
      "client_id" => "fac3591c-9785-11e9-bc42-526af7764f64",
      "card_number" => "1234123412341234",
      "exp_date" => "06/22",
      "card_holder_name" => "John S"
    ]);

    $order_1 = factory('App\Models\Order')->create([
      "client_id" => "fac3591c-9785-11e9-bc42-526af7764f64",
      "cart_id" => "c5b6c552-9757-11e9-bc42-526af7764f68",
      "order_date" => "2018-08-21",
    ]);

    $transaction_1 = factory('App\Models\Transaction')->create([
      "order_id" => $order_1->order_id,
      "credit_card_id" => $credit_card->credit_card_id,
      "client_id" => $order_1->client_id,
      "client_name" => "John Snow",
      "value_to_pay" => 100
    ]);

    $order_2 = factory('App\Models\Order')->create([
      "client_id" => "fac3591c-9785-11e9-bc42-526af7764f64",
      "cart_id" => "c5b6c552-9757-11e9-bc42-526af7764f69",
      "order_date" => "2019-02-20"
    ]);

    $transaction_2 = factory('App\Models\Transaction')->create([
      "order_id" => $order_2->order_id,
      "credit_card_id" => $credit_card->credit_card_id,
      "client_id" => $order_2->client_id,
      "client_name" => "John Snow",
      "value_to_pay" => 280
    ]);

    $this
      ->json('GET', '/store/api/v1/history')
      ->assertResponseStatus(200);

    $this
      ->json('GET', "/store/api/v1/history/{$order_2->order_id}")
      ->assertResponseStatus(200);
  }
}
