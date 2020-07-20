<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSopraelaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /**
         * project
         */
        if (!Schema::hasTable('project')) {
            Schema::create(
                'project', function (Blueprint $table) {
                    $table->engine = 'InnoDB';
                    $table->increments('id')->unsigned();
                    $table->string('name', 255)->nullable();
                    $table->integer('status')->nullable();
                    $table->string('dateCreated', 255)->nullable();
                    $table->string('dateModified', 255)->nullable();
                    $table->string('viewPolicy', 255)->nullable();
                    $table->string('editPolicy', 255)->nullable();
                    $table->string('joinPolicy', 255)->nullable();
                    $table->string('icon', 255)->nullable();
                    $table->string('color', 255)->nullable();
                    $table->string('mailKey', 255)->nullable();
                    $table->string('hasWorkboard', 255)->nullable();
                    $table->string('hasMilestones', 255)->nullable();
                    $table->string('hasSubprojects', 255)->nullable();
                    $table->string('properties', 255)->nullable();
                    $table->string('subtype', 255)->nullable();
                    $table->string('projectPath', 255)->nullable();
                    $table->string('projectDepth', 255)->nullable();
                    $table->string('projectPathKey', 255)->nullable();
                    $table->string('phid', 255)->nullable();
                    $table->string('authorPHID', 255)->nullable();
                }
            );
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project');
    }
}
