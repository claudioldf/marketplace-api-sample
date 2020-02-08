<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->string('cart_id');

            /*
            Nota: na tabela de atributos estava considerado INT, entretando no json estava string. 
            Mantive String, pois em todos os outros locais que referenciam este campo, estava como String.
            */
            $table->string('client_id');

            $table->string('product_id');
            $table->date('date');
            $table->time('time');

            /* Indexes */
            $table->index('cart_id');
            $table->index('client_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
