<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDinamicTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /**
         * Tableas pra associar um projeto, field, ou qlqr outra coisa a uma Referencia (NO caso a url personalizada do jira)
         */
        
        Schema::create(
            'references', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code');
                $table->string('name')->nullable();
            }
        );
        
        
        Schema::create(
            'referenceables', function (Blueprint $table) {
                $table->increments('id');
                $table->string('reference_id')->nullable();
                // $table->foreign('reference_id')->references('id')->on('references');
                $table->string('identify')->nullable();
                $table->string('referenceable_id');
                $table->string('referenceable_type');
            
                $table->index(['referenceable_id', 'referenceable_type']);
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
        Schema::dropIfExists('referenceables');
        Schema::dropIfExists('references');
    }
}
