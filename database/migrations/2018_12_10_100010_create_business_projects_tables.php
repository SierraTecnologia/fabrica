<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessProjectsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table(
            'project', function (Blueprint $table) {

                if (!Schema::hasColumn('project', 'url')) {
                    $table->string('url')->nullable();
                }
                if (!Schema::hasColumn('project', 'repository')) {
                    $table->string('repository')->nullable();
                }
                if (!Schema::hasColumn('project', 'code_language_id')) {
                    $table->string('code_language_id')->nullable();
                }
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
