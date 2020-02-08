<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        "product_id" => "c5b6c552-9757-11e9-bc42-526af7764f68",
        "artist" => "Pink Floyd",
        "year" => 1973,
        "album" => "Dask Side of The Moon",
        "price" => 250,
        "store" => "Minha Loja de Discos",
        "thumb" => "https://images-na.ssl-images-amazon.com/images/I/61R7gJadP7L._SX355_.jpg",
        "date" => "26/11/2018"
    ];
});

$factory->define(App\Models\Cart::class, function (Faker\Generator $faker) {
    return [
        "cart_id" => "d2eda25e-9757-11e9-bc42-526af7764f63",
        "client_id" => "fac3591c-9785-11e9-bc42-526af7764f64",
        "product_id" => "c5b6c552-9757-11e9-bc42-526af7764f68",
        "date" => "26/11/2019",
        "time" => "18:33:12"
    ];
});

$factory->define(App\Models\CreditCard::class, function (Faker\Generator $faker) {
    return [
        "client_id" => "fac3591c-9785-11e9-bc42-526af7764f64",
        "card_number" => "1234123412341234",
        "exp_date" => "06/22",
        "card_holder_name" => "John S"
    ];
});

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    return [
        "cart_id" => "d2eda25e-9757-11e9-bc42-526af7764f63",
        "client_id" => "fac3591c-9785-11e9-bc42-526af7764f64",
        "order_date" => "26/11/2019",
    ];
});

$factory->define(App\Models\Transaction::class, function (Faker\Generator $faker) {
    return [
        "order_id" => "d2eda25e-9757-11e9-abce-526af7764f62",
        "credit_card_id" => 0,
        "client_id" => "fac3591c-9785-11e9-bc42-526af7764f64",
        "client_name" => "John Snow",
        "value_to_pay" => "280"
    ];
});