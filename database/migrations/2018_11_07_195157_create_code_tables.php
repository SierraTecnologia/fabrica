<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'code_languages', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('slug')->nullable();
                $table->integer('status')->default(1);
                $table->string('code_language_id')->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            'code_sprints', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('type')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );

        Schema::create(
            'code_resolutions', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('type')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );

        Schema::create(
            'code_stages', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('type')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );
        Schema::create(
            'code_status', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('type')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );

        Schema::create(
            'code_fields', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->timestamps();
            }
        );

        Schema::create(
            'code_issue_fields', function (Blueprint $table) {
                $table->increments('id');
                $table->string('value');
                $table->string('code_field_code')->nullable();
                $table->string('code_issue_id')->nullable();
                $table->timestamps();
            }
        );


        Schema::create(
            'code_issue_relation_types', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            }
        );

        Schema::create(
            'code_issue_links', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code_issue_relation_type_id')->nullable();
                $table->string('from_code_issue_id')->nullable();
                $table->string('to_code_issue_id')->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            'code_libs', function (Blueprint $table) {
                $table->increments('id');


                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->string('url')->nullable();
                $table->string('repository')->nullable();
                $table->integer('code_language_id')->nullable();
                $table->string('type_id')->nullable();
                $table->integer('status')->default(1);
                $table->integer('is_public')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            'containers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('image')->nullable();
                $table->timestamps();
            }
        );

        if (Schema::hasTable('project')) {
            Schema::table(
                'project', function (Blueprint $table) {
                    $table->integer('is_public')->default(0);
                    $table->string('type_id')->nullable();
                    $table->integer('code_language_id')->nullable();
                    $table->string('url')->nullable();
                    $table->string('description')->nullable();
                    $table->string('reference')->nullable();
                    // $table->string('slug')->nullable();
                    $table->string('repository')->nullable();

                    // $table->increments('id');
                    // $table->string('name')->nullable();
                    // $table->integer('status')->default(1);
                    // $table->string('card_description')->nullable();
                    // $table->integer('money_id')->nullable();
                    // $table->integer('credit_card_id')->nullable();
                    // $table->string('user_token')->nullable();
                    // $table->string('company_token')->nullable();
                    // $table->decimal('total',6,2)->nullable();

                    // $table->string('installments')->nullable();

                    // $table->json('customer')->nullable();

                    // $table->string('device_token')->nullable();
                    // $table->string('device')->nullable();

                    // $table->string('gateway_token_cielo')->nullable();
                    // $table->string('gateway_token_rede')->nullable();
                    // $table->string('tid')->nullable();
                    // $table->integer('bank_slip_id')->nullable();

                    // $table->json('fraud_analysis')->nullable();

                    // $table->boolean('konduto')->nullable();
                    // $table->bigInteger('tax_id')->nullable();
                    // $table->string('billing_name')->nullable();
                    // $table->string('billing_address')->nullable();
                    // $table->string('billing_complement')->nullable();
                    // $table->string('billing_city')->nullable();
                    // $table->string('billing_state')->nullable();
                    // $table->string('billing_zip')->nullable();
                    // $table->string('billing_country')->nullable();
                    // $table->index('company_token');

                    $table->timestamps();
                }
            );
        }

        Schema::create(
            'code_releases', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('slug')->nullable();
                $table->integer('status')->default(1);
                $table->timestamp('release')->nullable();
                $table->timestamp('start')->nullable();
                $table->integer('code_project_id')->nullable();
                $table->integer('code_project_commit_id')->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            'code_issues', function (Blueprint $table) {
                $table->increments('id');
                $table->string('key_name');
                $table->string('slug')->nullable();
                $table->string('assign')->nullable();
                $table->string('reference')->nullable();
                $table->integer('status')->default(1);
                $table->string('url')->nullable();
                $table->string('code_project_id')->nullable();
                $table->timestamps();
            }
        );


        Schema::create(
            'code_project_commits', function (Blueprint $table) {
                $table->increments('id');
                $table->string('commit_code')->nullable();
                $table->string('author_name')->nullable();
                $table->string('author_email')->nullable();
                $table->integer('code_project_id')->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            'code_project_branchs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->integer('code_project_commit_id')->nullable();
                $table->integer('code_project_id')->nullable();
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
