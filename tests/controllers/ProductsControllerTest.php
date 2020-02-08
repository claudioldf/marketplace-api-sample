<?php
use Laravel\Lumen\Testing\DatabaseMigrations;

class ProductsControllerTest extends TestCase
{
  use DatabaseMigrations;

  /**
   * testShouldPersistAProduct
   *
   * @return void
   */
  public function testShouldPersistAProduct()
  {
    $data = [
      "product_id" => "d2eda25e-9757-11e9-bc42-526af7764f64",
      "artist" => "Pink Floyd",
      "year" => 1973,
      "album" => "Dask Side of The Moon",
      "price" => 250,
      "store" => "Minha Loja de Discos",
      "thumb" => "https://images-na.ssl-images-amazon.com/images/I/61R7gJadP7L._SX355_.jpg",
      "date" => "26/11/2018"
    ];

    $post = $this->post('/store/api/v1/product', $data);
    $post->assertJson(json_encode([
      'message' => 'Produto criado com sucesso.'
    ]));
    $post->assertResponseStatus(201);
  }

    /**
   * testShouldNotPersistAInvalidProduct
   *
   * @return void
   */
  public function testShouldNotPersistAInvalidProduct()
  {
    $data = [];

    $post = $this->post('/store/api/v1/product', $data);
    $post->assertJson(json_encode([
      "product_id" => [
        "O atributo product id é obrigatório."
      ],
      "artist" => [
        "O atributo artist é obrigatório."
      ],
      "year" => [
        "O atributo year é obrigatório."
      ],
      "album" => [
        "O atributo album é obrigatório."
      ],
      "price" => [
        "O atributo price é obrigatório."
      ],
      "store" => [
        "O atributo store é obrigatório."
      ],
      "thumb" => [
        "O atributo thumb é obrigatório."
      ],
      "date" => [
        "O atributo date é obrigatório."
      ]
    ]));
    $post->assertResponseStatus(422);
  }

  /**
   * testShouldReturnAllProducts
   *
   * @return void
   */
  public function testShouldReturnAllProducts()
  {
    $product1 = factory('App\Models\Product')->create([
      "product_id" => "d2eda25e-9757-11e9-bc42-526af7764f63",
      "artist" => "Pink Floyd",
      "year" => 1973,
      "album" => "Dask Side of The Moon",
      "price" => 250,
      "store" => "Minha Loja de Discos",
      "thumb" => "https://images-na.ssl-images-amazon.com/images/I/61R7gJadP7L._SX355_.jpg",
      "date" => "26/11/2018"
    ]);

    $product2 = factory('App\Models\Product')->create([
      "product_id" => "4a149a9a-9758-11e9-bc42-526af7764f64",
      "artist" => "U2",
      "year" => 1993,
      "album" => "Zooropa",
      "price" => 100,
      "store" => "Super Discos",
      "thumb" => "https://images-na.ssl-images-amazon.com/images/I/81ZmhD2lO8L._SL1200_.jpg",
      "date" => "01/02/2019"
    ]);

    $this
      ->json('GET', '/store/api/v1/products', [])
      ->seeJsonEquals([$product1, $product2]);
      // ->seeJsonStructure([$product1, $product2])
  }
}
