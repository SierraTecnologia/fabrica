<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrepareWorkflowTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(
            'stage_steps', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('icon')->nullable();
                $table->integer('status')->default(1);
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
    }
}
