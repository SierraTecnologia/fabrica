<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessVendasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(
            'venda_propostas', function (Blueprint $table) {
                $table->increments('id');
                $table->string('value')->nullable();
                $table->string('money_id')->nullable();
                $table->string('date')->nullable();
                $table->string('parcelas')->nullable();
                $table->string('is_active')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propostas');
    }
}
