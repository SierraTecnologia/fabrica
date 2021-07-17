<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepositoriesTables extends Migration
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
;        Schema::create(
            'repositories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code')->nullable();
                $table->string('name')->nullable();
            }
        );
        Schema::create(
            'repositorables', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('repository_id');
                // $table->foreign('repository_id')->references('id')->on('repositories');
                $table->string('head')->nullable();
                $table->string('repositorable_id');
                $table->string('repositorable_type');
            
                $table->index(['repositorable_id', 'repositorable_type']);
            }
        );

        Schema::create(
            'repository_commits', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code');
                $table->string('date')->nullable();
                $table->string('author')->nullable();
                $table->text('message')->nullable();
                $table->string('reference')->nullable();
                $table->integer('repository_id')->nullable();
                // $table->foreign('repository_id')->references('id')->on('repositories');
                $table->timestamps();
            }
        );
        Schema::create(
            'repository_tags', function (Blueprint $table) {
                $table->increments('id');
                $table->string('tag_code')->nullable();
                $table->integer('repository_id')->nullable();
                // $table->foreign('repository_id')->references('id')->on('repositories');
                $table->timestamps();
            }
        );

        Schema::create(
            'repository_branchs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->integer('repository_commit_id')->nullable();
                $table->integer('repository_id')->nullable();
                // $table->foreign('repository_id')->references('id')->on('repositories');
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
        Schema::dropIfExists('code_releases');
        Schema::dropIfExists('code_issues');
        Schema::dropIfExists('code_project_commits');
        Schema::dropIfExists('code_project_branchs');
        Schema::dropIfExists('code_projects');
        Schema::dropIfExists('code_languages');
    }
}
