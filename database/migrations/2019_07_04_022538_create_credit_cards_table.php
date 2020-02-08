<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->string('credit_card_id');
            $table->string('client_id');
            $table->string('card_number'); /* !! Irei salvar o número truncado, pois o número completo é inseguro !! */
            $table->string('card_holder_name');
            // $table->string('cvv'); /* !! Não se deve salva o digito verificador/segurança do cartão em banco de dados !! */
            $table->string('exp_date');

            $table->index('credit_card_id');
            $table->index(['client_id', 'card_number', 'exp_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_cards');
    }
}
