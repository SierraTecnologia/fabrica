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
        } else {

            Schema::table(
                'project', function (Blueprint $table) {
                    $table->string('name', 255)->nullable()->change();
                    $table->integer('status')->nullable()->change();
                    $table->string('dateCreated', 255)->nullable()->change();
                    $table->string('dateModified', 255)->nullable()->change();
                    $table->string('viewPolicy', 255)->nullable()->change();
                    $table->string('editPolicy', 255)->nullable()->change();
                    $table->string('joinPolicy', 255)->nullable()->change();
                    $table->string('icon', 255)->nullable()->change();
                    $table->string('color', 255)->nullable()->change();
                    $table->string('mailKey', 255)->nullable()->change();
                    $table->string('hasWorkboard', 255)->nullable()->change();
                    $table->string('hasMilestones', 255)->nullable()->change();
                    $table->string('hasSubprojects', 255)->nullable()->change();
                    $table->string('properties', 255)->nullable()->change();
                    $table->string('subtype', 255)->nullable()->change();
                    $table->string('projectPath', 255)->nullable()->change();
                    $table->string('projectDepth', 255)->nullable()->change();
                    $table->string('projectPathKey', 255)->nullable()->change();
                    $table->string('phid', 255)->nullable()->change();
                    $table->string('authorPHID', 255)->nullable()->change();

                    // if (!Schema::hasColumn('project', 'url')) {
                    //     $table->string('url')->nullable();
                    // }
                    // if (!Schema::hasColumn('project', 'repository')) {
                    //     $table->string('repository')->nullable();
                    // }
                    // if (!Schema::hasColumn('project', 'code_language_id')) {
                    //     $table->string('code_language_id')->nullable();
                    // }
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
