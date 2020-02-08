<?php
use Laravel\Lumen\Testing\DatabaseMigrations;

class CartsControllerTest extends TestCase
{
  use DatabaseMigrations;

  /**
   * addToCart
   *
   * @return void
   */
  public function testAddToCart()
  {
    $this->product = factory('App\Models\Product')->create([
      "product_id" => "c5b6c552-9757-11e9-bc42-526af7764f68",
      "artist" => "Pink Floyd",
      "year" => 1973,
      "album" => "Dask Side of The Moon",
      "price" => 250,
      "store" => "Minha Loja de Discos",
      "thumb" => "https://images-na.ssl-images-amazon.com/images/I/61R7gJadP7L._SX355_.jpg",
      "date" => "26/11/2018"
    ]);

    $data = [
      "cart_id" => "d2eda25e-9757-11e9-bc42-526af7764f63",
      "client_id" => "fac3591c-9785-11e9-bc42-526af7764f64",
      "product_id" => "c5b6c552-9757-11e9-bc42-526af7764f68",
      "date" => "26/11/2019",
      "time" => "18:33:12"
    ];

    $post = $this->post('/store/api/v1/add_to_cart', $data);
    $post->assertJson(json_encode([
      'message' => 'Produto adicionado ao carrinho com sucesso.'
    ]));
    $post->assertResponseStatus(201);
  }

    /**
   * testShouldValidateAnInvalidOrderBeforeOrderComplete
   *
   * @return void
   */
  public function testShouldValidateAnInvalidOrderBeforeOrderComplete()
  {
    $data = [];

    $post = $this->post('/store/api/v1/buy', $data);
    $post->assertJson(json_encode([
      "cart_id" => [
        "O atributo cart id é obrigatório."
      ],
      "client_id" => [
        "O atributo client id é obrigatório."
      ],
      "client_name" => [
        "O atributo client name é obrigatório."
      ],
      "value_to_pay" => [
        "O atributo value to pay é obrigatório."
      ],
      "credit_card.number" => [
        "O atributo credit card.number é obrigatório."
      ],
      "credit_card.cvv" => [
        "O atributo credit card.cvv é obrigatório."
      ],
      "credit_card.exp_date" => [
        "O atributo credit card.exp date é obrigatório."
      ],
      "credit_card.card_holder_name" => [
        "O atributo credit card.card holder name é obrigatório."
      ]
    ]));
    $post->assertResponseStatus(422);
  }

  /**
   * testShouldCompleteAnOrder
   *
   * @return void
   */
  public function testShouldCompleteAnValidOrder()
  {
    factory('App\Models\Product')->create([
      "product_id" => "c5b6c552-9757-11e9-bc42-526af7764f68",
      "artist" => "Pink Floyd",
      "year" => 1973,
      "album" => "Dask Side of The Moon",
      "price" => 250,
      "store" => "Minha Loja de Discos",
      "thumb" => "https://images-na.ssl-images-amazon.com/images/I/61R7gJadP7L._SX355_.jpg",
      "date" => "26/11/2018"
    ]);

    factory('App\Models\Cart')->create([
      "cart_id" => "d2eda25e-9757-11e9-bc42-526af7764f63",
      "client_id" => "fac3591c-9785-11e9-bc42-526af7764f64",
      "product_id" => "c5b6c552-9757-11e9-bc42-526af7764f68",
      "date" => "26/11/2019",
      "time" => "18:33:12"
    ]);

    $data = [
      "client_id" => "fac3591c-9785-11e9-bc42-526af7764f64",
      "cart_id" => "d2eda25e-9757-11e9-bc42-526af7764f63",
      "client_name" => "John Snow",
      "value_to_pay" => 280,
      "credit_card" => [
        "number" => "1234123412341234",
        "cvv" => 111,
        "exp_date" => "06/22",
        "card_holder_name" => "John S"
      ]
    ];

    $post = $this->post('/store/api/v1/buy', $data);
    $post->assertJson(json_encode([
      'message' => 'Compra finalizada com sucesso!'
    ]));
    $post->assertResponseStatus(201);
  }
}
