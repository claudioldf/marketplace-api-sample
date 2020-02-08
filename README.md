# About
REST API of a sample marketplace disk store developed using Laravel
Lumen Framework (PHP 7.3, MySql, PHPUnit).

All products are added into a shopping cart, and then pass through the
API to complete the an e-commerce transaction. 

This is a sample project, it just store data on database. There is no
integration with any payment gateway.

# Endpoints

### POST `/store/api/v1/product`
Create a new product on database
```json
{
   "product_id":"d2eda25e-9757-11e9-bc42-526af7764f64",
   "artist":"Pink Floyd",
   "year":1973,
   "album":"Dask Side of The Moon",
   "price":250,
   "store":"Minha Loja de Discos",
   "thumb":"https://images-na.ssl-images-amazon.com/images/I/61R7gJadP7L._SX355_.jpg",
   "date":"26/11/2018"
}
```
+ Product

| Field       | Type    |
|-------------|---------|
| product_id  | String  |
| artist      | String  |
| year        | Integer |
| album       | String  |
| price       | Integer |
| store       | String  |
| thumb       | String  |
| date        | String  |

### GET `/store/api/v1/products`
Return a list of all products persisted on database
```json
[
  {
    "product_id":"d2eda25e-9757-11e9-bc42-526af7764f64",
    "artist":"Pink Floyd",
    "year":1973,
    "album":"Dask Side of The Moon",
    "price":250,
    "store":"Minha Loja de Discos",
    "thumb":"https://images-na.ssl-images-amazon.com/images/I/61R7gJadP7L._SX355_.jpg",
    "date":"26/11/2018"
  },
  {
    "product_id":"4a149a9a-9758-11e9-bc42-526af7764f64",
    "artist":"U2",
    "year":1993,
    "album":"Zooropa",
    "price":100,
    "store":"Super Discos",
    "thumb":"https://images-na.ssl-images-amazon.com/images/I/81ZmhD2lO8L._SL1200_.jpg",
    "date":"01/02/2019"
  },
  {
    "product_id":"53f2b33a-9758-11e9-bc42-526af7764f64",
    "artist":"The Beatles",
    "year":1969,
    "album":"Abbey Road",
    "price":180,
    "store":"Old School Discos",
    "thumb":"https://images-na.ssl-images-amazon.com/images/I/919WO8q-nnL._SL1500_.jpg",
    "date":"13/06/2019"
  }
]
```

+ Product

| Field       | Type    |
|-------------|---------|
| product_id  | String  |
| artist      | String  |
| year        | Integer |
| album       | String  |
| price       | Integer |
| store       | String  |
| thumb       | String  |
| date        | String  |

### POST `/store/api/v1/add_to_cart`
Add a new item/product to shopcart
```json
{
   "cart_id":"c5b6c552-9757-11e9-bc42-526af7764f64",
   "client_id":"fac3591c-9785-11e9-bc42-526af7764f64",
   "product_id":"d2eda25e-9757-11e9-bc42-526af7764f64",
   "date":"26/11/2018"
   "time":"18:33:12"
}
```
+ Cart

| Field       | Type    |
|-------------|---------|
| cart_id     | String  |
| client_id   | Integer |
| product_id  | String  |
| date        | String  |
| time        | String  |

### POST `/store/api/v1/buy`
Complete the buy process.
* Note: Products should be added to cart before invoke this method.
```json
{
   "client_id":"fac3591c-9785-11e9-bc42-526af7764f64",
   "cart_id":"c5b6c552-9757-11e9-bc42-526af7764f64",
   "client_name":"John Snow",
   "value_to_pay":280,
   "credit_card":{
      "number":"1234123412341234",
      "cvv":111,
      "exp_date":"06/22",
      "card_holder_name":"John S",
   }
}
```

+ Transaction

| Field        | Type       |
|--------------|------------|
| client_id    | String     |
| client_name  | String     |
| total_to_pay | Integer    |
| credit_card  | CreditCard |

+ CreditCard

| Field            | Type    |
|------------------|---------|
| card_number      | String  |
| card_holder_name | String  |
| cvv              | Integer |
| exp_date         | String  |


### GET `/store/api/v1/history`
Return the orders history
```json
[
   {
      "client_id":"fac3591c-9785-11e9-bc42-526af7764f64",
      "order_id":"569c30dc-6bdb-407a-b18b-3794f9b206a1",
      "card_number":"**** **** **** 1234",
      "value":100,
      "date":"21/08/2018"
   },
   {
      "client_id":"fac3591c-9785-11e9-bc42-526af7764f64",
      "order_id":"569c30dc-6bdb-407a-b18b-3794f9b206a2",
      "card_number":"**** **** **** 1234",
      "value":280,
      "date":"20/02/2019"
   },
   {
      "client_id":"fac3591c-9785-11e9-bc42-526af7764f64",
      "order_id":"569c30dc-6bdb-407a-b18b-3794f9b206aa",
      "card_number":"**** **** **** 1234",
      "value":500,
      "date":"29/06/2019"
   }
]
```

+ History

| Field            | Type    |
|------------------|---------|
| card_number      | String  |
| cliend_id        | String  |
| value            | Integer |
| order_id         | String  |

### GET `/store/api/v1/history/{clientId}`
Return all orders from an giver client
```json
[
   {
      "client_id":"fac3591c-9785-11e9-bc42-526af7764f64",
      "order_id":"569c30dc-6bdb-407a-b18b-3794f9b206a1",
      "value":180,
      "date":"19/01/2019",
      "card_number":"**** **** **** 1234"
   },
   {
      "client_id":"fac3591c-9785-11e9-bc42-526af7764f64",
      "order_id":"569c30dc-6bdb-407a-b18b-3794f9b206a2",
      "value":100,
      "date":"20/06/2019",
      "card_number":"**** **** **** 1234"
   }
]
```

# Requirements
- Used 7.3, but it runs ok with php 7.1(>=)
- php composer package manager
- phpunit (if you want to run the tests code)
- mysql-client php mod enabled
- mysql-server (if you'd like to run the mysql server database locally)


# Project setup
##### 1. Firstly, copy the file .env.example on the root directory of the project.

```bash
cd <your-root-project-diretory>
cp .env.example .env
```

##### 2. Now, open the .env file and edit these lines:
```
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=mydatabase
	DB_USERNAME=myusername
	DB_PASSWORD=mypassword
``

##### 3. Create an strong security key for you app, to protected the traffic of your application. In order to do it, run on terminal:
```bash
php -r "echo bin2hex(random_bytes(32));"
```

###### It will print something like this code:
```
c970d1dadffa1011afb4eaecf0b851b83f073b49ee644a5a4c29c09448e90717
```

##### 4. Copy this security key code, edit the .env file again, and paste this code on ```APP_KEY=``` attribute
> ...
**APP_KEY=c970d1dadffa1011afb4eaecf0b851b83f073b49ee644a5a4c29c09448e90717**
...

#### 5. Install composer package manager, if you don't have it installed in your local yet.
```
See: https://getcomposer.org/download/
```

#### 6. Install project dependencies through composer:
```bash
cd <your-root-project-diretory>
composer install
```


#### 5. With .env file ok, you can now run migrations, to create all tables that this project require. So, type in your terminal/console:
```bash
php artisan migrate
```

## Run the application
To run the application locally, you should open the terminal/console and type:

```bash
php artisan migrate
php -S localhost:8000 -t public
```

The server will be stared and running on ```localhost:8000```

## Reset database
###### You can reset the database by typing:
```bash
php artisan migrate:refresh
```

## Run tests scripts (phpunit)
```bash
cd <your-root-project-diretory>
./vendor/bin/phpunit
```
> Tests response:
>
> OK (7 tests, 13 assertions)


## Tools used for development
- Insomnia or Postman (to test Restful API)
- PHP 7.3.6 + Lumen framework v5.8.10
- phpunit
- Linux / MacOS
- Visual Code IDE
- MySQL Server (for database)
- MySQL Workbench

## Troubles

##### If you are running mysql server version 8, or you  have this kind of error message:
```bash
In Connection.php line 664:

  SQLSTATE[HY000] [2054] The server requested authentication method unknown to the client (SQL: select * from information_sch
  ema.tables where table_schema = marketplace_sample_api and table_name = migrations and table_type = 'BASE TABLE')


In Connector.php line 70:

  SQLSTATE[HY000] [2054] The server requested authentication method unknown to the client


In Connector.php line 70:

  PDO::__construct(): The server requested authentication method unknown to the client [caching_sha2_password]
```

###### In order to solve it, you can login into you mysql and type the follow:

```bash
$ mysql -u root -p123123

mysql> CREATE USER myusername@"%" IDENTIFIED WITH mysql_native_password BY 'mypassword';
mysql> GRANT ALL PRIVILEGES ON *.* TO 'myusername'@'%';
mysql> FLUSH PRIVILEGES;
mysql> CREATE DATABASE marketplace_sample_api;
mysql> exit;
```

#### Test using Insominia
You have Insomnia installed, you can import my Workspace with all calls for this api, I add a file called ````Insomnia_API_Call_Docs.json```` on the root folder on the project.
