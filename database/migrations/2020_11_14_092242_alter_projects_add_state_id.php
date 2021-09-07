<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProjectsAddStateId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('projects','state')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('state');
            });
        }

        Schema::table('projects',function (Blueprint $table) {
            $table->unsignedBiginteger('state_id')->after('places');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('projects', 'state_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('state_id')->after; // enum column
            });
        }
    }
}
