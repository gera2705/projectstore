<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeadlineMiddleware extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('is_scanned'); // enum column
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->tinyInteger('is_scanned')->default(0)->after('error_message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->tinyInteger('is_scanned')->default(0);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('is_scanned');
        });
    }
}
