<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComputerCatalogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'instancias', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );

        Schema::create(
            'computer_catalogs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('type');
                $table->string('location');
                $table->integer('status')->default(1);
                $table->integer('parent_id');
                $table->integer('instancia_id');
                $table->timestamps();
            }
        );
        // Schema::create(
        //     'workflow_stages', function (Blueprint $table) {
        //         $table->increments('id');
        //         $table->integer('workflow_id')->nullable();
        //         $table->integer('stage_id')->nullable();
        //         $table->timestamps();
        //     }
        // );
        // Schema::create(
        //     'workflow_item_types', function (Blueprint $table) {
        //         $table->increments('id');
        //         $table->string('model');
        //         $table->string('filter')->nullable();
        //         $table->integer('status')->default(1);
        //         $table->timestamps();
        //     }
        // );
        // Schema::create(
        //     'workflow_transactions', function (Blueprint $table) {
        //         $table->increments('id');
        //         $table->string('name');
        //         $table->integer('workflow_id')->nullable();
        //         $table->integer('stage_from_id')->nullable();
        //         $table->integer('stage_to_id')->nullable();
        //         $table->timestamps();
        //     }
        // );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflow_item_types');
    }
}
