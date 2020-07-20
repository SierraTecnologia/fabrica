<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfraTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(
            'infra_services', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('url')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );
        Schema::create(
            'infra_ambientes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->string('branch')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );
        
        Schema::create(
            'infra_ssh_keys', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->text('private_key')->nullable();
                $table->text('public_key')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );
        Schema::create(
            'infra_computers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('ip')->nullable();
                $table->string('instance')->nullable();
                $table->string('user')->nullable();
                $table->string('password')->nullable();
                $table->string('ssh_port')->nullable();
                $table->string('url')->nullable();
                $table->integer('status')->default(1);
                $table->integer('infra_ambiente_id')->nullable();
                $table->integer('integration_id')->nullable();
                $table->integer('infra_ssh_key_id')->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            'infra_loggers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('content')->nullable();
                $table->string('infra_computer_id')->nullable();
                $table->string('reference_id')->nullable();
                $table->string('date')->nullable();
                $table->integer('type')->default(1)->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            'infra_deploys', function (Blueprint $table) {
                $table->increments('id');
                $table->string('install_path')->nullable();
                $table->integer('status')->default(1);
                $table->integer('integration_id')->nullable();
                $table->integer('infra_ambiente_id')->nullable();
                $table->integer('infra_computer_id')->nullable();
                $table->integer('code_project_id')->nullable();
                $table->timestamps();
            }
        );

        
        /**
         * DOminios
         */
        Schema::create(
            'infra_domains', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('url')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );

        Schema::create(
            'infra_subdomains', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('url')->nullable();
                $table->integer('status')->default(1);
                $table->integer('infra_domain_id')->nullable();
                $table->timestamps();
            }
        );
        Schema::create(
            'infra_dominio_rules', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('url')->nullable();
                $table->integer('status')->default(1);
                $table->integer('infra_domain_id')->nullable();
                $table->timestamps();
            }
        );

        /**
         * Bancos de Dados
         */
        Schema::create(
            'infra_databases', function (Blueprint $table) {
                $table->increments('id');
                $table->string('host')->nullable();
                $table->string('username')->nullable();
                $table->string('password')->nullable();
                $table->string('port')->nullable();
                $table->integer('type_id')->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            'infra_database_collections', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->integer('infra_database_id')->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            'infra_database_tables', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->integer('infra_database_collection_id')->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            'infra_database_columns', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('type')->nullable();
                $table->string('defaut_value')->nullable();
                $table->string('accept_null')->nullable();
                $table->integer('infra_database_table_id')->nullable();
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
        Schema::dropIfExists('infra_services');
        Schema::dropIfExists('infra_ambientes');
        Schema::dropIfExists('infra_computers');
        Schema::dropIfExists('infra_deploys');
        Schema::dropIfExists('infra_database_columns');
        Schema::dropIfExists('infra_database_tables');
        Schema::dropIfExists('infra_database_collections');
        Schema::dropIfExists('infra_databases');
        Schema::dropIfExists('infra_dominio_rules');
        Schema::dropIfExists('infra_subdomains');
        Schema::dropIfExists('infra_domains');
    }
}
