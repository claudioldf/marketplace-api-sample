<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('transaction_id');
            $table->string('client_id');
            $table->string('client_name');
            $table->string('order_id');

            /*
            Nota: Na tabela de atributos estava "total_to_pay", todavia no json estava "value_to_pay".
            Leven em conta o json, isto é, "value_to_pay"
            */
            $table->integer('value_to_pay');

            /*
            Por questão de segurança no relacionamento do objeto Transaction com CreditCard,
            Crei uma coluna chamada credit_card_id para gerar o relacionamento entre estas entidades.
            Pois não podemos salvar o número do cartão de forma explicita, assim como salvar truncado,
            ex **** **** **** 1234, temos grande possibilidade deste número repetir, para outros cartões, 
            e com isso criar incosistencia no banco, ou até mesmo exibir o cartão errado ao cliente.
            */
            $table->string('credit_card_id');

            // Idexes
            $table->index('transaction_id');
            $table->index('client_id');
            $table->index('order_id');
            $table->index('credit_card_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
